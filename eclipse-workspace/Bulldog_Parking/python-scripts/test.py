#!/usr/bin/env python3
import random

count = 0
string = ""
while(count < 7):
    x = random.randrange(0,3)
    string = string + str(x) 
    count = count + 1

file = open("test.txt", "w")
file.write(string)
file.close()