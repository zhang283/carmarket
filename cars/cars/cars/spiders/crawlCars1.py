# -*- coding: utf-8 -*-
import scrapy
import urlparse
from cars.items import CarsItem


class Crawlcars1Spider(scrapy.Spider):
    name = "crawlCars1"
    allowed_domains = ["edmunds.com"]
    start_urls = (
        'http://www.edmunds.com/',
    )

    def parse(self, response):
        for href in response.xpath('//ul[@class="list_of_items"]/li/a/@href'):
            url = response.urljoin(href.extract())
            urlSplit = url.split("/")
            print urlSplit
            if urlSplit[-3] == "www.edmunds.com":
                yield scrapy.Request(url, callback=self.parse_make)

    def parse_make(self, response):
        for href in response.xpath('//div[@class="info1 ab-challenger"]/p[@class="name"]/a/@href'):
            url = response.urljoin(href.extract())
            yield scrapy.Request(url, callback=self.parse_year)

    def parse_year(self, response):
        for href in response.xpath('//div[@class="info1"]/p[@class="name"]/a/@href'):
            url = urlparse.urljoin('http://www.edmunds.com/',href.extract())
            url = urlparse.urljoin(url,'features-specs/')
            yield scrapy.Request(url, callback=self.parse_feature)

    def parse_feature(self, response):
            item = CarsItem()
            item['title'] = response.xpath('/html/head/title/text()').extract()
            item['displacement'] = response.xpath('//table[@class="items"]/tr/td/label[contains(text(),"BASE ENGINE SIZE")]/following-sibling::span/text()').extract();
            item['power'] = response.xpath('//table[@class="items"]/tr/td/label[contains(text(),"HORSEPOWER")]/following-sibling::span/text()').extract();
            item['torque'] = response.xpath('//table[@class="items"]/tr/td/label[contains(text(),"TORQUE")]/following-sibling::span/text()').extract();
            item['fuel'] = response.xpath('//table[@class="items"]/tr/td/label[contains(text(),"FUEL TYPE")]/following-sibling::span/text()').extract();
            item['maker'] = response.xpath('//div[@class="grid-216  no-gutter-top"]/div[@class="content"]/a/text()').extract();
            item['fuelEcon'] = response.xpath('//div[@class="data-table wide col two-col gutter-top-4"]/ul/li/em/a/text()').extract();
            item['carType'] = response.xpath('//div[@class="data-table wide col two-col gutter-top-4"]/ul/li/span[contains(text(),"CAR TYPE")]/following-sibling::em/text()').extract();
            item['transmissioin'] = response.xpath('//div[@class="data-table wide col two-col gutter-top-4"]/ul/li/span[contains(text(),"TRANSMISSION")]/following-sibling::em/text()').extract();
	    item['basicWarranty'] = response.xpath('//div[@class="data-table wide col two-col gutter-top-4"]/ul/li/span[contains(text(),"BASIC WARRANTY")]/following-sibling::em/text()').extract();
	    item['blueTooth'] = response.xpath('//div[@class="data-table wide col two-col gutter-top-4"]/ul/li/span[contains(text(),"BLUETOOTH")]/following-sibling::em/text()').extract();
	    item['heatedSeats'] = response.xpath('//div[@class="data-table wide col two-col gutter-top-4"]/ul/li/span[contains(text(),"HEATED SEATS")]/following-sibling::em/text()').extract();
	    item['engineType'] = response.xpath('//div[@class="data-table wide col two-col gutter-top-4"]/ul/li/span[contains(text(),"ENGINE TYPE")]/following-sibling::em/text()').extract();
	    item['totalSeating'] = response.xpath('//div[@class="data-table wide col two-col gutter-top-4"]/ul/li/span[contains(text(),"TOTAL SEATING")]/following-sibling::em/text()').extract();
	    item['cylinder'] = response.xpath('//div[@class="data-table wide col two-col gutter-top-4"]/ul/li/span[contains(text(),"CYLINDERS")]/following-sibling::em/text()').extract();
	    item['driveTrain'] = response.xpath('//div[@class="data-table wide col two-col gutter-top-4"]/ul/li/span[contains(text(),"DRIVE TRAIN")]/following-sibling::em/text()').extract();
	    item['navigation'] = response.xpath('//div[@class="data-table wide col two-col gutter-top-4"]/ul/li/span[contains(text(),"NAVIGATION")]/following-sibling::em/text()').extract();
            
            yield item  