import turtle
import random
import time
import tkinter

puntaje=0
record=0
pausa=0.1

#Creacioón de la ventana
ventana=turtle.Screen()
ventana.title("Snake - Man")
ventana.bgcolor("white")
ventana.setup(width=500,height=600)

#Datos de la serpiente
snake=turtle.Turtle()
snake.shape("square")
snake.color("black")
snake.penup()
snake.goto(0,0)
snake.direction="Stop"

#Datos de la comida
food=turtle.Turtle()
#forma=random.choice('triangle','circle')
food.shape("circle")
food.color("yellow")
food.speed(0)
food.penup()
food.goto(0,100)


#Inicialización de la pantalla
pantalla=turtle.Turtle()
pantalla.speed(0)
pantalla.shape('square')
pantalla.color('black')
pantalla.penup()
pantalla.hideturtle()
pantalla.goto(0,250)
pantalla.write("Your_score= 0 Highest_score= 0", align="center")
fuente=("Arial",40, "normal")
turtle.mainloop()
