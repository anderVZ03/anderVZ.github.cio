import time

inicio=time.time() #toma el tiempo en este punto como inicio
lista = [i for i in range(0,10000001,1)]
for x in range (0,len(lista),1):
    if lista[x]==1:
        print (lista[x], " En el indice: ",x)
fin=time.time() #toma el tiempo en este punto como final
print(fin-inicio) #se imprime la diferencia de tiempo
print ("\n")

#######################################

ini=time.time()
numbuscado=1 #aquí se pone el numero a buscar
n=len(lista) #números de elementos
mitad=n//2 #indicamos la primera mitad
i=0 #auxiliar para el while
while i!=-1:
    if (mitad==-1 or mitad==10000002): #Esto es para considerar numeros que no existen en el array
        print("No existe")
        i=-1
    else:
        if lista[mitad]==numbuscado:
            print(lista[mitad], " En el indice: ",mitad) #Si el numero buscado resulta ser igual se imprime y se pone el i=-1 para terminar el ciclo
            i=-1
        else:
            if lista[mitad]<numbuscado: #Si el indice que está a la mitad es menor que el numero buscado entonces se define una nueva mitad
                                        #En plan así: (imaginen que es una recta que va de 0 a la cantidad de elementos, y el asterisco es la primera mitad) <-------------------*---------------------->
                                        #Entonces después de ejecutarse esto queda una recta aumentada con la primera mitad "Solo en teoría":                <--------------------------------------------------------------->
                                        #Aquí es donde se considera la nueva mitad que coincide con la mitad de arriba:                                      <--------------------------------*----------------------------->
                                        #Aqui les dibujo para que puedan ver que si se asimila que se toma la mitad de la mitad derecha                      <-------------------*------------*--------->
                                        #Y así infinitamente
                mitad=(n+mitad)//2
            else:
                n=mitad
                mitad=mitad//2 #Si el indice que está a la mitad es mayor que el numero buscado entonces se define una nueva mitad considerando solo los elementos que están a la izquierda
                               #En plan así: (imaginen que es una recta que va de 0 a la cantidad de elementos, y el asterisco es la primera mitad) <-------------------*---------------------->
                               #Entonces después de ejecutarse esto queda una recta reducida:                                                       <------------------->
                               #Aquí es donde se considera la nueva mitad:                                                                          <---------*--------->
                               #Y así sucesivamente
fi=time.time()
print (fi-ini)
#El punto de esto es que comparen que los tiempos de ejecucion son menores si se hace una busqueda binaria que una normal