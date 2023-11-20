from NodoDePila import NodoDePila
class ClasePila(NodoDePila):
    def __init__(self):
        self.pila=None
        self.tamanioDePila=0
        pass

    def Empty(self):
        return self.pila==None
        pass


    def insertarElemento(self, dato=str):
        pilatemporal=NodoDePila(dato)
        pilatemporal.setsiguienteDato(self.pila)
        self.pila=pilatemporal
        self.tamanioDePila=self.tamanioDePila +1
        pass

    def leerPila(self):
        if(ClasePila.Empty(self) is False):
            pilatemporal=self.pila
            while(pilatemporal!=None):
                print(pilatemporal.getdato())
                pilatemporal=pilatemporal.getsiguienteDato()
                pass
            pass
    pass

    def eliminarElemento(self):
        if (ClasePila.Empty(self) is False):
            self.pila=self.pila.getsiguienteDato()
            self.tamanioDePila=self.tamanioDePila -1
            pass
        pass
    
    def tamanio(self):
        return self.tamanioDePila