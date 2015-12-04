# -*- coding: utf-8 -*-
import scrapy


class CrawlcarsbmwSpider(scrapy.Spider):
    name = "crawlCarsBMW"
    allowed_domains = ["edmunds.com"]
    start_urls = (
        'http://www.edmunds.com/bmw',
    )

    def parse(self, response):
		filename = response.url.split("/")[-2] + '.html'
		with open(filename, 'wb') as f:
			f.write(response.body)