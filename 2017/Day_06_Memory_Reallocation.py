
def doStuff(input, part_two = False):
    input_len = len(input)
    total_allocations = 0
    track_cycles = []
    allocations = set()
    raw_allocations = []
    while True:

        [max_index, max_val] = findMax(input)
        input[max_index] = 0
        next_index = max_index + 1
        orig_max = max_val
        
        while max_val > 0:
            if( next_index >= input_len):
                next_index = 0
            #print(max_val)    
            input[next_index] += 1
            max_val -= 1
            orig_index = next_index
            next_index += 1
    
        this_item = ",".join(str(s) for s in input)
        allocations.add(this_item)
        
        if part_two == True:
            raw_allocations.append([total_allocations,this_item])
        
        #print("Step: " + str(total_allocations) + "\n"+str(allocations))
        total_allocations += 1

        if( total_allocations > len(allocations)):
            print("Steps: " + str(total_allocations))
            
            # Part Two: Match items in "raw_allocations" by getting the step number it was created and the difference between the current step number
            if(part_two == True):
                for item in raw_allocations:
                    if this_item == item[1]:
                        print("Cycles between match: " + str(total_allocations-1 - item[0]))
                        break
            return False




def findMax(input):
    input_max = max(input)
    i=0
    for s in input:
        if s == input_max:
            return [i,s]
        else:
            i += 1  
    

# Original Advent of Code input
input = [5,	1,	10,	0,	1,	7,	13,	14,	3,	12,	8,	10,	7,	12,	0,	6]

# Do stuff! This includes part two of the puzzle. To disable part two, change True to False
doStuff(input,True)
