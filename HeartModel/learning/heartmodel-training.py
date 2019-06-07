import pandas as pd
import numpy as np
from sklearn.neural_network import MLPClassifier
from joblib import dump, load
from sys import argv

df = pd.read_csv('New_data.csv')
#print(df)

df = df.drop(range(7),axis=0)
#print(df)
size = len(df.columns)-1
df_x = df.drop(df.columns[[0,1,size]],axis=1)
#print(df_x)

df_y = df.iloc[:,-1]
#print(df_y.shape)

X = df_x.astype(np.float64)
y = df_y.astype(np.float64)

#print(type(y.iloc[0]))

from sklearn.model_selection import train_test_split
X_train, X_test, y_train, y_test = train_test_split(X, y)
X_train = X_train.values.tolist()
y_train = y_train.values.tolist()
X_test = X_test.values.tolist()
y_test = y_test.values.tolist()

#print(len(X_train[0]))

clf = MLPClassifier(solver='adam', alpha=1e-5, hidden_layer_sizes=(13, 13), random_state=1)

n = int(argv[1])

best = [0., 0.]
avg = [0., 0.]
ensemble = [0., 0.]

from warnings import filterwarnings
filterwarnings('ignore')

for i in range(n):

	start = int(i*len(X_train)/n); end = int((i+1)*len(y_train)/n)
	clf.fit(X_train[start:end],y_train[start:end])

	dump(clf, 'filename.joblib')

	#clf = load('filename.joblib')
	train, test = clf.score(X_train[start:end],y_train[start:end]), clf.score(X_test,y_test)
	if(best[1] < test):
		best[0] = train; best[1] = test
	avg[0] += train; avg[1] += test

avg[0] = avg[0]/n; avg[1] = avg[1]/n

print('Best: ', best[0], best[1])
print('Avg: ', avg[0], avg[1])

#print(clf.predict(X_test))
