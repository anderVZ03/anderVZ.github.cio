from NodoCola import Nodo
class Cola(Nodo):
    def __init__(self):
        self.frente=None
        self.cola=None
        self.tamanio=0
        pass

    def Empty(self):
        return self.frente==None
    
    def Insertar(self, dato):
        nuevo_nodo = Nodo(dato)
        
        if self.cola is None:
            self.frente = nuevo_nodo
        else:
            self.cola.siguiente = nuevo_nodo
        
        self.cola = nuevo_nodo
    pass


    def recorrer(self):
        actual = self.cola
        
        while actual is not None:
            print(actual.getdato())
            actual = actual.siguienteNodo