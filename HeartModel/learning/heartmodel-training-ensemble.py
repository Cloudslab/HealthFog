import pandas as pd
import numpy as np
from sklearn.neural_network import MLPClassifier
from sklearn.ensemble import BaggingClassifier
from joblib import dump, load
from sys import argv
import random

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

def new_acc(y1, y2):
	count = 0;
	for i in range(len(y1)):
		if y1[i] == y2[i]:
			count += 1
	return count / len(y1)

def func1(y_pred):
	y_pred_max = []
	for i in range(len(y_pred[0])):
		count0 = 0
		count1 = 0
		for j in range(len(y_pred)):
			if y_pred[j][i] <= 0.5:
				count0 += 1
			else:
				count1 += 1
		if count0 == count1:
			m = random.randint(0,1)
		elif count0 > count1:
			m = 0
		else:
			m = 1
		y_pred_max += [m]
	return y_pred_max

y_pred_train = []
y_pred_test = []

for i in range(n):

	start = int(i*len(X_train)/n); end = int((i+1)*len(y_train)/n)
	clf.fit(X_train[start:end],y_train[start:end])

	dump(clf, 'filename.joblib')

	#clf = load('filename.joblib')
	train, test = clf.score(X_train[start:end],y_train[start:end]), clf.score(X_test,y_test)
	if(best[1] < test):
		best[0] = train; best[1] = test
	avg[0] += train; avg[1] += test

	y_pred_train += [clf.predict(X_train)]
	y_pred_test += [clf.predict(X_test)] 

avg[0] = avg[0]/n; avg[1] = avg[1]/n

# print(y_pred_train[0])
y_pred_max_train = func1(y_pred_train)
y_pred_max_test = func1(y_pred_test)

# print("new accuracy train:",new_acc(y_pred_max_train,y_train))
# print("new accuracy test:",new_acc(y_pred_max_test,y_test))

# print('Best: ', best[0], best[1])
# print('Avg: ', avg[0], avg[1])

#print(clf.predict(X_test))

bclf = BaggingClassifier(base_estimator=MLPClassifier(), n_estimators=n, bootstrap=True)
bclf.fit(X_train,y_train)
m1 = 0
m2 = 0
sum1 = 0
sum2 = 0
for i in range(n):
	# print(bclf[i].score(X_train,y_train))
	if bclf[i].score(X_train,y_train) > m1:
		m1 = bclf[i].score(X_train,y_train)
	sum1 += bclf[i].score(X_train,y_train)

	if bclf[i].score(X_test,y_test) > m2:
		m2 = bclf[i].score(X_test,y_test)
	sum2 += bclf[i].score(X_test,y_test)

print('Best train:',m1)
print('Best test:',m2)
print('Avg train:',sum1/n)
print('Avg test:',sum2/n)
print('Train:',bclf.score(X_train,y_train))
print('Test:',bclf.score(X_test,y_test))