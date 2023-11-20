from POO1 import Primera 
class Segunda(Primera):
    def __init__(self,num1,num2,num3):
        Primera.__init__(self,num1,num2)
        self.num3=num3
        pass
    def suma2(self):
        return(Primera.suma(self)+self.num3)
        pass
    def toString(self):
        return (Primera.toString(self)+" num 3: "+str(self.num3)+" suma123: "+str(Segunda.suma2(self)))
        pass
    pass
Objeto1=Segunda(1,2,3)
print(Objeto1.suma2())
print(Objeto1.toString())