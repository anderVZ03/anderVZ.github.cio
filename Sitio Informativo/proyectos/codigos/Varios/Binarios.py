from cmath import log


def Binario_a_decimal(numero_binario):
	numero_decimal = 0 
	for posicion, digito_string in enumerate(numero_binario[::-1]):
		numero_decimal += int(digito_string) * 2 ** posicion

	return numero_decimal

def generador_matriz(length, combinationVector, fullMatrix):
    if len(combinationVector) <= length:
        matrixToFillWithOne = combinationVector.copy()
        matrixToFillWithZero = combinationVector.copy()
        matrixToFillWithOne.append(1)
        matrixToFillWithZero.append(0)
        generador_matriz(length,matrixToFillWithOne,fullMatrix)
        generador_matriz(length,matrixToFillWithZero,fullMatrix)
    
    else:
        fullMatrix.append(combinationVector)
        fullMatrix.sort()
    return fullMatrix


def combinaciones_Host(tamanio,parte_inicial):
    array =generador_matriz(tamanio,[],[])
    recolector=[]
    for i in range (0,len(array),1):
         string=""
         for j in range (0,tamanio,1):
            string=string+str(array[i][j])
         pass
         recolector.append(Binario_a_decimal(parte_inicial+string))
    return recolector

def combinaciones_Subredes(tamanio):
    array =generador_matriz(tamanio,[],[])
    recolector=[]
    for i in range (0,len(array),1):
         string=""
         for j in range (0,tamanio,1):
            string=string+str(array[i][j])
         recolector.append((string))
    return recolector

def ordenar_array(arreglo):
    ordenado=[]
    for item in arreglo:
        if item not in ordenado:
            ordenado.append(item)
        
    return ordenado

def ImprimirHost(array):
     for i in range(0,len(array),1):
          if (i==0):
               print(str(array[i])+" -> Esta es dedicada al flujo de red\n")
          elif(i==len(array)-1):
            print("\n\n"+str(array[i])+" ->Esta es dedicada al broadcast")
          else:
            print(str(array[i]),end=", ")
          pass
     pass
     

def Host(tamanio,binario_inicial):
     arreglo=ordenar_array(combinaciones_Host(tamanio, binario_inicial))
     ImprimirHost(arreglo)
     pass


def generacion_binarios(tam,tipo):
     string=""
     for i in range(0,tam,1):
          string=string+tipo
          pass
     return string

def Subneteo_redes(redes,base=1):
    if(redes<=2**base):
          string_unos=generacion_binarios(base,"1")
          string_ceros=generacion_binarios(8-base,"0")
          arreglo=ordenar_array(combinaciones_Subredes(base))
          contador=1
          for item in arreglo:
               print("\n\n--------------------Estas son las host para la red "+str(contador)+"-----------------------")
               Host(8-base,str(item))
               contador=contador+1
          return "\nSu máscara de red para "+str(redes)+" subredes quedará: 255.255.255."+str(Binario_a_decimal(string_unos+string_ceros))
    else:
        return Subneteo_redes(redes,base+1)
    

def Subneteo_host(host,base=1):
     if(host+2<=2**base):
          string_unos=generacion_binarios(8-base,"1")
          string_ceros=generacion_binarios(base,"0")
          arreglo=ordenar_array(combinaciones_Subredes(8-base))
          print("\n\n--------------------Estas son las host para la red-----------------------")
          Host(base,str(string_ceros))
          return "\nSu máscara de red para "+str(host)+" host quedará: 255.255.255."+str(Binario_a_decimal(string_unos+string_ceros))
     else:
        return Subneteo_host(host,base+1)

def ImprimirSubneteo():
     opcion=int(input("Ingrese su opción: \n1. Crear subredes\n2. Crear subred para una cantidad de host\n"))
     if(opcion==1):
          subredes=int(input("Ingrese la cantidad de subredes que necesita: "))
          print(Subneteo_redes(subredes))
          pass
     elif(opcion==2):
          host=int(input("Ingrese la cantidad de host que necesita: "))
          print(Subneteo_host(host))


ImprimirSubneteo()








def Subredes(tamanio, binario_final):
     arreglo=ordenar_array(combinaciones_Subredes(tamanio,binario_final))
     ImprimirSubredes(arreglo)
     pass

def  ImprimirSubredes(array):
     print ("--------------------Estas son las subredes--------------------")
     for i in array:
          print ("\t"+str(i))
          pass
     pass
