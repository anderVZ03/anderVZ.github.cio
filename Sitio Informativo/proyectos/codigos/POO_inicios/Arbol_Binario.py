class Tree:
    def __init__(self,padre=None,hijoI=None,hijoD=None):
        self.padre=padre
        self.hijoI=hijoI
        self.hijoD=hijoD
        pass
    def getpadre(self):
        return self.padre
        pass
    def gethijoI(self):
        return self.hijoI
        pass
    def gethijoD(self):
        return self.hijoD
        pass
    def setpadre(self,padre):
        self.padre=padre
        pass
    def sethijoI(self,hijoI):
        self.hijoI=hijoI
        pass
    def sethijoD(self,hijoD):
        self.hijoD=hijoD
        pass
    def toString(self):
        return ("Padre: "+str(self.padre)+"\n"+"Hijo Izquierdo: "+str(self.hijoI)+"\n"+"Hijo Derecho: "+str(self.hijoD))
    def contador(num):
        num=num+1
        return num
        pass
    

def Compa(arbol,cadena):
    if (arbol.getpadre()!=None):
        if (cadena<arbol.getpadre()):
            if (arbol.gethijoI()==None):
                class arbol2(Tree):
                    def __init__(self,padre=None,hijoI=None,hijoD=None):
                        Tree.__init__(self,padre,hijoI,hijoD)
                        pass
                    pass
                arbol3=arbol2(cadena)
                arbol.sethijoI(arbol3)
                print(arbol3.getpadre())
            else:
                class arbol2(Tree):
                    def __init__(self,padre=None,hijoI=None,hijoD=None):
                        Tree.__init__(self,padre,hijoI,hijoD)
                        pass
                    pass
                arbol3=arbol2()
                Compa(arbol3,cadena)
            pass
        else:
            if (arbol.gethijoD()==None):
                class arbol2(Tree):
                    def __init__(self,padre=None,hijoI=None,hijoD=None):
                        Tree.__init__(self,padre,hijoI,hijoD)
                        pass
                    pass
                arbol3=arbol2(cadena)
                arbol.sethijoD(arbol3)
                print(arbol3.getpadre())
            else:
                class arbol2(Tree):
                    def __init__(self,padre=None,hijoI=None,hijoD=None):
                        Tree.__init__(self,padre,hijoI,hijoD)
                        pass
                    pass
                arbol3=arbol2()
                Compa(arbol3,cadena)
            pass
    else:
        arbol.setpadre(cadena)
        print(arbol.getpadre())
        pass
    pass
pass

array=[]

def Recorrer(arbol,contador):
    arbolauxiliar=arbol.gethijoI()
    if (arbolauxiliar.getpadre()==None):
        array.append(arbolauxiliar)
        print(arbol.getpadre())
        arbolauxiliar2=arbol.gethijoD()
        if (arbolauxiliar2.getpadre==None):
            if (contador!=0):
                arbolaux=array[contador-1]
                arbol2=arbolaux.gethijoD()
                Recorrer(arbol2,contador)
            pass
        else:
            arbol2=arbol.gethijoI()
            Recorrer(arbol2,contador)
            pass
    else:
        array.append(arbolauxiliar)
        contador=contador+1
        arbol2=arbol.gethijoI()
        Recorrer(arbol2,contador)
        pass
    pass
import time

arbol=Tree()
contador=0
bandera=True
while (bandera==True):
    opc=int(input("QUE DESEA HACER"+"\n"+"\n"+"1. Agregar un elemento"+"\n"+"2. Visualizar árbol"+"\n"+"3. Salir"+"\n"+"Ingrese su opción: "))
    if (opc<4 and opc>0):
        if (opc==1):
            cadena=int(input("Ingrese la cadena: "))
            Compa(arbol,cadena)
            #print("\n\n"+arbol.toString()+"\n\n")
        if (opc==2):
            Recorrer(arbol,contador)
            pass
        if (opc==3):
            print("Gracias")
            bandera=False
            pass
        time.sleep(0)
        pass
    else:
        print("\nSe ha ingresado una opción errónea\n")
        time.sleep(3)

