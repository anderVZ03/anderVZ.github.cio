class Nodo:
    def __init__(self, dato):
        self.dato=dato
        self.siguienteNodo=None
        pass

    def getdato(self):
        return self.dato
        pass
    def setdato(self, dato):
        self.dato=dato
        pass
    def getsiguienteNodo(self):
        return self.siguienteNodo
    pass

    def setsiguienteNodo(self,Nodo):
        self.siguienteNodo=Nodo