# -*- coding: utf-8 -*-

# Define here the models for your scraped items
#
# See documentation in:
# http://doc.scrapy.org/en/latest/topics/items.html

import scrapy


class CarsItem(scrapy.Item):
    # define the fields for your item here like:
    '''
        title = scrapy.Field()
        displacement = scrapy.Field()
        power = scrapy.Field()
        torque = scrapy.Field()
        fuel = scrapy.Field()
        maker = scrapy.Field()	
        fuelEcon = scrapy.Field
	carType = scrapy.Field()
	transmissioin = scrapy.Field()
	basicWarranty = scrapy.Field()
	blueTooth = scrapy.Field()
	heatedSeats = scrapy.Field()
	engineType = scrapy.Field()
	totalSeating = scrapy.Field()
	cylinder = scrapy.Field()
	driveTrain = scrapy.Field()
	navigation = scrapy.Field()
	price = scrapy.Field()
    '''
    address = scrapy.Field()
    phone = scrapy.Field()
    name = scrapy.Field()
    car = scrapy.Field()
    vin = scrapy.Field()
    price = scrapy.Field()
    url = scrapy.Field()