
import sys
from collections import defaultdict

def other(pair, x): return pair[0] if x == pair[1] else pair[1]

def search(m, avail, cur):
    top = 0, 0
    for choice in m[cur]:
        if choice not in avail: continue
        avail.remove(choice)
        l, v = search(m, avail, other(choice, cur))
        l += 1
        v += choice[0] + choice[1]
        top = max(top, (l, v))
        avail.add(choice)
    return top

def doThis(myList):
    data = [tuple(map(int, s.strip().split("/"))) for s in myList]
    print(len(data), len(set(data)))

    avail = set(data)
    m = defaultdict(list)
    for a in avail:
        m[a[0]] += [a]
        m[a[1]] += [a]

    print(search(m, avail, 0))






puzzle_input = "31/13,34/4,49/49,23/37,47/45,32/4,12/35,37/30,41/48,0/47,32/30,12/5,37/31,7/41,10/28,35/4,28/35,20/29,32/20,31/43,48/14,10/11,27/6,9/24,8/28,45/48,8/1,16/19,45/45,0/4,29/33,2/5,33/9,11/7,32/10,44/1,40/32,2/45,16/16,1/18,38/36,34/24,39/44,32/37,26/46,25/33,9/10,0/29,38/8,33/33,49/19,18/20,49/39,18/39,26/13,19/32"

doThis(puzzle_input.split(","))
#test1 = flattenArray(pi_comp)
#test2 = getUnique(test1)
#test3 = getMatches(test2,pi_comp)
# print(test3)
#print(test2[0], "\nLargest: " + str(test2[1]))
