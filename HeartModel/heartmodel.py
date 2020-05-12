import pandas as pd
from joblib import load
import sys
from numpy import genfromtxt
import numpy as np
import warnings
warnings.simplefilter("ignore")

filename = sys.argv[1]

df = genfromtxt(filename, delimiter=',')

X = [df.astype(np.float64)]

clf = load('heartmodel.joblib')

result = clf.predict(X)[0].astype(int)

file = open('output.txt','w')
file.write(str(result))
file.close()