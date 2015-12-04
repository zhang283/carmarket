# -*- coding: utf-8 -*-

# Define here the models for your scraped items
#
# See documentation in:
# http://doc.scrapy.org/en/latest/topics/items.html

import scrapy


class CarsItem(scrapy.Item):
    # define the fields for your item here like:
    # name = scrapy.Field()
        title = scrapy.Field()
	totalInfo = scrapy.Field()
	#fuelEcon = scrapy.Field()
	carType = scrapy.Field()
	transmissioin = scrapy.Field()
	basicWarranty = scrapy.Field()
	blueTooth = scrapy.Field()
	heatedSeats = scrapy.Field()
	engineType = scrapy.Field()
	totalSeating = scrapy.Field()
	cylinder = scrapy.Field()
	driveTrain = scrapy.Field()
	consumerRating = scrapy.Field()
	navigation = scrapy.Field()
	subLink = scrapy.Field()
	# link = scrapy.Field()
	# desc = scrapy.Field()
