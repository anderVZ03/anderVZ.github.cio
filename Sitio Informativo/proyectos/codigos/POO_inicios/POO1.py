from datetime import datetime
fecha=datetime.now()
class Primera:
    #Constructor
    def __init__(self, num1, num2):
        self.num1=num1
        self.num2=num2
        fecha.date()
        pass
    #Metodos getter and setter
    def getnum1(self):
        return self.num1
        pass
    def getnum2(self):
        return self.num2
        pass
    def setnum1(self,nuevonum1):
        self.num1=nuevonum1
        pass
    def setnum2(self,nuevonum2):
        self.num2=nuevonum2
        pass
    def fecha(self):
        return fecha.now()
        pass
    #Métodos
    def suma(self):
        return(self.num1+self.num2)
    def toString(self):
        return ("hola, esta es mi poo en python, "+ str(self.num1)+ " num2: "+ str(self.num2)+" result: "+str(self.suma())+" "+str(self.fecha()))
        pass
    pass




#Objeto1=Primera(1,2)
#print(Objeto1.suma())
#Objeto1.setnum1(3)
#print(Objeto1.toString())