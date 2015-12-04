# -*- coding: utf-8 -*-
import scrapy
import urlparse
from cars.items import CarsItem


class CrawlDealerSpider(scrapy.Spider):
    name = "crawlDealer"
    allowed_domains = ["edmunds.com"]
    start_urls = (
        'http://www.edmunds.com/',
    )
    
    def parse(self, response):
        for href in response.xpath('//ul[@class="list_of_items"]/li/a/@href'):
            url = response.urljoin(href.extract())
            urlSplit = url.split("/")
            if urlSplit[-3] == "www.edmunds.com":
                yield scrapy.Request(url, callback=self.parse_make)

    def parse_make(self, response):
        for href in response.xpath('//div[@class="info1 ab-challenger"]/p[@class="name"]/a/@href'):
            url = response.urljoin(href.extract())
            yield scrapy.Request(url, callback=self.parse_year)

    def parse_year(self, response):
        for href in response.xpath('//div[@class="info1"]/p[@class="name"]/a/@href'):
            url = urlparse.urljoin('http://www.edmunds.com/',href.extract())
            yield scrapy.Request(url, callback=self.parse_inventory)
        
    def parse_inventory(self, response):
        suburl = response.xpath('//h2/a/@href').extract();
        if len(suburl)==6:
            splitArray = suburl[4].split('&')
            url = 'http://www.edmunds.com/inventory/srp.html?radius=200&zip=61820'
            for i in range(2, len(splitArray)):
                url = url+'&'+splitArray[i];
            yield scrapy.Request(url, callback=self.parse_inventory_d)

    def parse_inventory_d(self, response):
        for href in response.xpath('//ul[@class="grid-64 col description-col"]/li[@class="vehicle-name"]/a/@href'):
            url = "http://www.edmunds.com/"+href.extract()
            yield scrapy.Request(url, callback=self.parse_inventory_last_step)
            
    def parse_inventory_last_step(self, response):
        item = CarsItem()
        item['address'] = response.xpath('//div[@class="dealer-address"]/span/text()').extract()
        item['name'] = response.xpath('//li[@class="vi-li-dn"]/a/text()').extract()
        item['phone'] = response.xpath('//div[@class="vi-li-dp"]/text()').extract()
        car = response.xpath('//h1[@class="gutter-top-1 gutter-horizontal-3"]/span/text()').extract()[0]
        carArray = car.split('\n')
        item['car'] =  carArray[0].strip(' ')
        for i in range (1, len(carArray)):
            item['car'] = item['car']+' '+carArray[i].strip(' ')
        item['url'] = response
        item['price'] = 'Not Listed'
        tempList = response.xpath('//span[@class="msrp-price"]/text()').extract()[0].split('\n')
        for i in range(0, len(tempList)):
            if len(tempList[i].strip(' '))>0:
                item['price'] = tempList[i].strip(' ')
                break;
        item['vin'] = response.xpath('//li[@class="vi-vin top"]/text()').extract()[1].split(' ')[1]
        yield item
        
            
            

