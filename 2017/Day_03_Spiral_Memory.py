import math

def nearestSquare(target_val,cur_val=1):
    matrix = []
    i = 0 #Current iteration
    v = 1 #current vector size like - 1x1, 3x3, 5x5...
    side = 0 # "length" of the middles parts of any side
    corner =  [1,2,3,4]
    cur_val = 0
    while cur_val <= target_val:
        if(i == 0):
            continue
        
        cur_val = doCheck(cur_val)
        i += 1
        v += 2
        corner[0] = corner[0]+2
        corner[1] = corner[0]+4
        corner[2] = corner[0]+6
        corner[2] = corner[0]+8
    return cur_val
    
def buildArray(v,array):
    buildLen = v-1

    prev_vals = []
    for k in range(0,int(buildLen)):
        if(k==0):
            #only get first and last
            return
        elif(k==v-2 or k== v-4 or k==v-6 or k==v-8):
            return
    for i in range(0,4):
       vals[i] = []
    return array
def doCheck(input, i):
    return
    ##



def nearestPerfectSquare(input):
    rootN = math.sqrt(input)
    floorN = int(rootN)
    ceilN = floorN + 1
    floorN_sq = floorN*floorN
    ceilN_sq = ceilN*ceilN
    if(input - floorN_sq < ceilN_sq - input):
        return floorN_sq
    else:
        return ceilN_sq


def totalDistance(target,last_square):
    # input is the total vector squares (1x1, 3x3, 4x4, etc)
    # target is the target square for the algorithm
    midPoint = int(last_square/2)
    squares_per_vec = last_square-1
    total_squares = squares_per_vec*4
    distance = total_squares - target
    #print(total_squares,distance,midPoint)
    #a = getQuadrant(distance,squares_per_vec)
    y_step = 0
    for i in range(0,int(last_square),2):
        y_step += 1
    y_step += -1
    print("Target:", target, "Mid:", midPoint,"X:",target-midPoint, "Y:",y_step)
    out = target - midPoint + y_step
    return out






puzzle_input = 325489

cSquare = nearestPerfectSquare(puzzle_input)
last_square = math.sqrt(cSquare)
#print(cSquare)
#print(last_square) #This shows that the final square at this current level is the 571st square
target_pos = cSquare - puzzle_input
#print(target_pos)
output = totalDistance(target_pos,last_square,puzzle_input,cSquare)
print(output)