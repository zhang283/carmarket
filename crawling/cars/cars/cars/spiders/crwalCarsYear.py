# -*- coding: utf-8 -*-
import scrapy


class CrwalcarsyearSpider(scrapy.Spider):
    name = "crwalCarsYear"
    allowed_domains = ["edmunds.com"]
    start_urls = (
        'http://www.edmunds.com/bmw/x5-m/suv/years/',
    )

    def parse(self, response):
		filename = response.url.split("/")[-2] + '.html'
		with open(filename, 'wb') as f:
			f.write(response.body)