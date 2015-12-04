# -*- coding: utf-8 -*-
import scrapy


class CrawlcarsSpider(scrapy.Spider):
    name = "crawlCars"
    allowed_domains = ["edmunds.com"]
    start_urls = (
        'http://www.edmunds.com/',
    )

    def parse(self, response):
		filename = response.url.split("/")[-2] + '.html'
		with open(filename, 'wb') as f:
			f.write(response.body)
