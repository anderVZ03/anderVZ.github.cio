class NodoDePila:
    
    #Constructor
    def __init__(self, dato=str):
        self.dato=dato
        siguienteDato=NodoDePila
        pass

    def setdato(self, dato=str):
        self.dato=dato
        pass

    def getdato(self):
        return self.dato
        pass

    def setsiguienteDato(self, NuevoNodo):
        self.siguienteDato=NuevoNodo
        pass
    def getsiguienteDato(self):
        return self.siguienteDato
        pass
    


