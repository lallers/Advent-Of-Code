    
def state_change_a(x,curs_pos,max_iters,cur_iter = 0):
    if(cur_iter < max_iters):
        current_pos = x[curs_pos]
        if(current_pos== 0):
            x[curs_pos] = 1
            curs_pos += 1
            cur_iter += 1
            output(x,cur_iter,'B')
            state_change_b(x,curs_pos,max_iters,cur_iter)
        else:
            x[curs_pos] = 0
            curs_pos += -1
            cur_iter += 1
            output(x,cur_iter,'B')
            state_change_b(x,curs_pos,max_iters,cur_iter)
    else:
        output(x = x,finished = "yes")
        return [x,curs_pos,cur_iter]
def state_change_b(x,curs_pos,max_iters,cur_iter = 0):
    if(cur_iter < max_iters):
        current_pos = x[curs_pos]
        if(current_pos== 0):
            x[curs_pos] = 1
            curs_pos += -1
            cur_iter += 1
            output(x,cur_iter,'A')
            state_change_a(x,curs_pos,max_iters,cur_iter)
        else:
            x[curs_pos] = 0
            curs_pos += 1
            cur_iter += 1
            output(x,cur_iter,'A')
            state_change_a(x,curs_pos,max_iters,cur_iter)
    else:
        output(x = x,finished = "yes")
        return [x,curs_pos,cur_iter]

      
def output(x=[],iter=0,state="", finished = None ):
    if(finished != None):
        print('Diagnotic Checksum:\t' + str(sum(x)))
        return
    print('... '+'\t'.join(str(v) for v in x)+' ... (after '+str(iter)+' step;     about to run state '+state+')')

x = [0,0,0,0,0,0]
start_pos = 3
max_iters = 5
print('... '+'\t'.join(str(v) for v in x)+' ... (before any steps;     about to run state A)')
state_change_a(x,start_pos,max_iters)
