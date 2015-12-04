# -*- coding: utf-8 -*-
import scrapy
from cars.items import CarsItem


class carPriceSpider(scrapy.Spider):
    name = "carPrice"
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
            print url
            yield scrapy.Request(url, callback=self.parse_price)
            
    def parse_price(self, response):
        item = CarsItem()
        item['price'] = response.xpath('//div[@class="msrp"]/span/text()').extract();
        item['title'] = response.xpath('//div[@class="info1"]/p[@class="name"]/a/text()').extract();
        yield item