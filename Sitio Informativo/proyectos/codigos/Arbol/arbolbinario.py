class nodo:
    def __init__(self, dato):
        self.dato=dato
        self.izquierdo=None
        self.derecho=None
        pass

    def getDato(self):
        return self.dato
    
    def setDato(self, dato):
        self.dato=dato
        pass 

    def getIzquierdo(self):
        return self.izquierdo
    
    def getDerecho(self):
        return self.derecho
    
    def setIzquierda(self,nuevoIzquierdo):
        self.izquierdo=nuevoIzquierdo
        pass

    def setDerecha(self, nuevoDerecho):
        self.derecho=nuevoDerecho
        pass

    pass

class claseArbol(nodo):
    def __init__(self):
        self.raiz=None
        self.tamanio=0
        pass

    def vacio(self):
        return self.raiz==None
    
    def tamanio(self):
        return self.tamanio
    
    def insetar(self, dato):
        if(claseArbol.vacio()):
            raiz=nodo(dato)
            pass
        else:

            pass
        tamanio+=1
