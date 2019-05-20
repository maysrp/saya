import random
import time
class snake_game:
    def __init__(self,x=128,y=64):
        self.apple=[]
        self.y=y
        self.x=x
        self.snake=[[random.randint(0,self.x-1),random.randint(0,self.y-1)]]
        self.position={'l':'r','r':'l','u':'d','d':'u'}
        self.awsd=random.choice('lrud')
        self.point=0
        self.step=0
        self.game=True
        self.create_apple()
    def create_apple(self):
        x=random.randint(0,self.x-1) 
        y=random.randint(0,self.y-1)
        if self.duang_apple(x,y):
            return self.create_apple()
        else:
            self.apple=[x,y]
    def duang(self,x,y):
        #true GameOver
        if x>=0 and y>=0 and x<=self.x-1 and y<=self.y-1:
            if self.snake[-1][0]==x and self.snake[-1][1]==y:
                return False
            for swap in self.snake:
                if swap[0]==x and swap[1]==y:
                    return True
                else:
                    return False
        else:
            return True
    def duang_apple(self,x,y):
        #true not apple
        if x>=0 and y>=0 and x<=self.x-1 and y<=self.y-1:
            for swap in self.snake:
                if swap[0]==x and swap[1]==y:
                    return True
                else:
                    return False
        else:
            return True
    def snake_do(self,awsd=False): 
        if not awsd:
            self.trun_on(self.awsd)
        else:
            if self.awsd==awsd or awsd==self.position[awsd]:
                self.trun_on(self.awsd)
            elif 1:
                self.trun_on(awsd)                
            else:
                self.trun_on(awsd)                
            self.awsd=awsd
    def trun_on(self,xp):
        self.awsd=xp
        if xp=='r':
            new_step_x=self.snake[0][0]+1
            new_step_y=self.snake[0][1]
        elif xp=='l':
            new_step_x=self.snake[0][0]-1
            new_step_y=self.snake[0][1]
        elif xp=='u':
            new_step_x=self.snake[0][0]
            new_step_y=self.snake[0][1]-1
        else:
            new_step_x=self.snake[0][0]
            new_step_y=self.snake[0][1]+1
        if self.duang(new_step_x,new_step_y):
            self.game=False
        else:
            new_step=[new_step_x,new_step_y]
            self.snake.insert(0,new_step)
            if new_step_x==self.apple[0] and new_step_y==self.apple[1]:
                self.point+=1
                self.create_apple()
            else:
                self.snake.pop() 
        self.step+=1

            

#a0left:w1up:s2down:d3right
#a:x-1 d:x+1 w:y-1 s=y+1
snake=snake_game()
print(snake.snake)
snake.create_apple()
snake.apple[0]=snake.snake[0][0]+1
snake.apple[1]=snake.snake[0][1]
print(snake.apple)
print(snake.awsd)
snake.snake_do('r')
print(snake.awsd)
print(snake.snake)
print(snake.point)
print(snake.step)
snake.apple[0]=snake.snake[0][0]+1
snake.apple[1]=snake.snake[0][1]
snake.snake_do('r')

print(snake.snake)
print(snake.point)
print(snake.step)
