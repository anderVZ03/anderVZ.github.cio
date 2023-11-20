class Seleccionfutbol:
    def __init__(self, nombre=str, apellido=str, anioborn=int):
        self.nombre=nombre
        self.apellido=apellido
        self.anioborn=anioborn
        pass
    def getnombre(self):
        return self.nombre
        pass
    def getapellido(self):
        return self.apellido
        pass
    def getanio(self):
        return self.anioborn
        pass
    def setnombre(self,newnombre):
        self.nombre=newnombre
        pass
    def setapellido(self,newapellido):
        self.apellido=newapellido
        pass
    def setanio(self,newanio):
        self.anioborn=newanio
        pass
    def calcularedad(self):
        return(2022-self.anioborn)
        pass
    def string(self):
        return("Hola soy "+self.nombre+" "+ self.apellido+"\nSoy del año "+str(self.anioborn)+" por lo tanto tengo: "+str(self.calcularedad()))
        pass
    pass

class Jugador(Seleccionfutbol):
    def __init__(self,nombre=str,apellido=str,anioborn=int,num=int, altura=float, peso=float):
        Seleccionfutbol.__init__(self,nombre, apellido,anioborn)
        self.num=num
        self.altura=altura
        self.peso=peso
        pass

    def arreglo(self):
        arreglo=[2,3]
        return(arreglo[0])
        pass
    def getnum(self):
        return self.num
        pass
    def getaltura(self):
        return self.altura
        pass
    def getpeso(self):
        return self.peso
        pass
    def setnum(self,newnum):
        self.num=newnum
        pass
    def setaltura(self,newaltura):
        self.altura=newaltura
        pass
    def setpeso(self, newpeso):
        self.peso=newpeso
        pass
    def imc(self):
        return(self.peso/(self.altura)**2)
        pass
    def string(self):
        return("Hola soy "+self.nombre+" "+ Seleccionfutbol.getapellido(self)+"\nSoy del año "+str(Seleccionfutbol.getanio(self))+" por lo tanto tengo: "+str(Seleccionfutbol.calcularedad(self))
        +"\nSoy un jugador, y mi numero es: "+ str(self.num)+"\nAltura: "+str(self.altura)+"\nPeso: "+str(self.peso)+"\nIMC: "+str(self.imc()))
        pass
    def iterado(self):
        return(Seleccionfutbol.string(self)+"\nSoy un jugador, y mi numero es: "+ str(self.num)+"\nAltura: "+str(self.altura)+"\nPeso: "+str(self.peso)+"\nIMC: "+str(self.imc()))
        pass

        
