import time
import sys
from collections import deque
'''
def state_change_a(x, curs_pos, max_iters, cur_iter=0):
    if(cur_iter < max_iters):
        current_pos = x[curs_pos]
        if(current_pos == 0):
            x[curs_pos] = 1
            curs_pos += 1
            cur_iter += 1
            output(x, cur_iter, 'B')
            state_change_b(x, curs_pos, max_iters, cur_iter)
        else:
            x[curs_pos] = 0
            curs_pos += -1
            cur_iter += 1
            output(x, cur_iter, 'B')
            state_change_b(x, curs_pos, max_iters, cur_iter)
    else:
        output(x=x, finished="yes")
        return [x, curs_pos, cur_iter]


def state_change_b(x, curs_pos, max_iters, cur_iter=0):
    if(cur_iter < max_iters):
        current_pos = x[curs_pos]
        if(current_pos == 0):
            x[curs_pos] = 1
            curs_pos += -1
            cur_iter += 1
            output(x, cur_iter, 'A')
            state_change_a(x, curs_pos, max_iters, cur_iter)
        else:
            x[curs_pos] = 0
            curs_pos += 1
            cur_iter += 1
            output(x, cur_iter, 'A')
            state_change_a(x, curs_pos, max_iters, cur_iter)
    else:
        output(x=x, finished="yes")
        return [x, curs_pos, cur_iter]
'''

def state_change(x=[0, 0, 0, 0, 0, 0], curs_pos=3, max_iters=1, cur_state="A", cur_iter=0):
    x = deque(x)
    print("Starting Checksum...")
    while(cur_iter < max_iters):
        #print("Iteration ... %s of %s" % (cur_iter, max_iters), end="\r" )
        #sys.stdout.flush()

        # Length calculation once
        len_X = len(x)
        #print("Cursor: " + str(curs_pos) + " XLen: " + str(len_X) )
        # Make x and "infinite" list
        
        if curs_pos == len_X:
            #print("Cursor: " + str(curs_pos)+ " X: " + str(len_X) +"\r" )
            x.append(0)
        elif abs(curs_pos) > len_X:
            #print("Cursor: " + str(curs_pos)+ " X: " + str(len_X) +"\r" )
            x.appendleft(0)

        # Getting state specific values and modifications
        state_vals = states(cur_state, x[curs_pos])
        
        # Change values based on state
        cur_state = state_vals[0]
        x[curs_pos] = state_vals[1]
        curs_pos += state_vals[2]
        
        cur_iter += 1
    print("Length of x: " +str(len(x)) +"\nChecksum Value: " + str(sum(x)))


def states(state = "A", val = 0):
    # Define 'out' as [Next state, Write Value, Move Value]
    if state == "A":
        if val == 0:
            out = ["B", 1, 1]
        else:
            out = ["C", 0, -1]
    elif state == "B":
        if val == 0:
           out = ["A", 1, -1]
        else:
            out = ["D", 1, 1]
    elif state == "C":
        if val == 0:
           out = ["A", 1, 1]
        else:
            out = ["E", 0, -1]
    elif state == "D":
        if val == 0:
           out = ["A", 1, 1]
        else:
            out = ["B", 0, 1]
    elif state == "E":
        if val == 0:
           out = ["F", 1, -1]
        else:
            out = ["C", 1, -1]
    elif state == "F":
        if val == 0:
           out = ["D", 1, 1]
        else:
            out = ["A", 1, 1]
    else:
        print("... Error in state checking ...")
        out = ["A",0,0]
    return out
       


def output(x=[], iter=0, state="", finished=None):
    if(finished != None):
        print('Diagnotic Checksum:\t' + str(sum(x)))
        return

    print('... '+'\t'.join(str(v) for v in x)+' ... (after ' +
          str(iter)+' step;     about to run state '+state+')')


x = [0] * 10000
max_iters = 12919244
start_pos = int(len(x)//2) + 1

state_change(x, start_pos, max_iters)
