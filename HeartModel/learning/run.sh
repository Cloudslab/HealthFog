max=5
for (( i=1; i <= $max; ++i ))
do
    python3 heartmodel-training.py $1
done
