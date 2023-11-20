import os
try:
    libro=open("archivo.txt","r+")
    #print(libro.read())
    libro.write("\nSoy AndersonVelasquez\n")
    print(libro.readlines(2))

except (ZeroDivisionError,ValueError,NameError,FileNotFoundError):
    print("Ups, se ha producido un error")
    pass
