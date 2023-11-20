def factorial(num): #2
    #if not isinstance(num, int) or num < 0:
    if (num==0):
        return 1
    else:
        return num*factorial(num-1) #2*(1*(1))
print (factorial(2))

def fibonachi(cant):
    if (cant==0 or cant==1):
        return cant
    else:
        return fibonachi(cant-1)+fibonachi(cant-2)
print(fibonachi(10))

def Sumaentero(n):
    if (n==1):
        return 1
    else:
        return n+Sumaentero(n-1)
print(Sumaentero(10))

def Producti(n,m):
    if (m==1):
        return n
    else:
        return n+Producti(n,m-1)
print(Producti(2,4))

def Potencia(n,m):
    if (m==0):
        return 1
    else:
        return n*(Potencia(n,m-1))
print(Potencia(2,4))

def invertir_cadena(cadena):
    letra=cadena[0]
    if (len(cadena)==1):
        return cadena
    else:
        return invertir_cadena(cadena[1:len(cadena)])+letra
print(invertir_cadena("Hola"))

def SumaInfinita(n):
    if (n==1):
        return n
    else:
        return (1/n)+SumaInfinita(n-1)
print(SumaInfinita(4))

def Contar(n):
    if (n/10<1):
        return 1
    else:
        return 1+(Contar(n/10))
print(Contar(12345678910))

def InvertirNum(n):
    if (n/10<1):
        return n
    else:
        return (n-(n//10))+InvertirNum(n//10)
print(InvertirNum(1434))

def CalcularMCD(n,m):
    if (m>n):
        aux=m
        m=n
        n=aux
    if (n%m==0):
        return m
    else:
        return CalcularMCD(m,n%m)
print(CalcularMCD(21,14))

def CalcularMCM(n,m):
    if (m>n):
        aux=m
        m=n
        n=aux
    if (m*n==n):
        return n
    else:
        return CalcularMCM(n-1,m)
print(CalcularMCM(4,20))

archivo=open("/home/anderson/Escritorio/Cuentos")

string_referencia=archivo.read()
print ("\n"+str(archivo.tell()))
print(string_referencia)
saveforline=archivo.readlines()
print ("\n"+str(archivo.tell()))
