import json 
jsonData = open('features.json')

data = json.load(jsonData)


	# make 
	# model
	# year
	# fuelEcon
	# carType
	# transmissioin
	# basicWarranty
	# blueTooth
	# heatedSeats
	# engineType
	# totalSeating
	# cylinder
	# driveTrain
	# navigation


info = []
text = []
for line in data:

	if len(line['totalInfo']) >= 13 and len(line['fuelEcon']) == 1:
		tmp = []
		tmp.append(line['fuelEcon'][0])
		for i in line['totalInfo']:
			if len(i.lstrip().rstrip()) != 0:
				if i.lstrip().rstrip() != 'Not Available' or (i.lstrip().rstrip() == 'Not Available' and len(tmp) != 10):
					tmp.append(i.lstrip().rstrip())
	 	text.append(tmp)
	 	subLink = line['subLink'].split('/')
	 	info.append([subLink[-6],subLink[-5],subLink[-4]])

output = open('features.txt','w')
output.truncate()

for i in range(0,len(info)):
	# print i,info[i], text[i]
	# print len(info[i]),len(text[i])
	output.write(str(info[i]+text[i])+'\n')


