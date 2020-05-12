import os
import time

while True:
	if(os.path.exists("./data.csv")):
		print("Got job")
		os.system("python3 heartmodel.py data.csv")
		os.remove("data.csv")
	else:
		time.sleep(0.1)