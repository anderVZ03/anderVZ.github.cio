import tensorflow as tf
import numpy as np
import matplotlib.pyplot as eje

arreglo1 = np.array([-40, -10, 0, 8, 15, 22, 38], dtype=float)
arreglo2 = np.array([-40, 14, 32, 46, 59, 72, 100], dtype=float)

capa = tf.keras.layers.Dense(units=1, input_shape=[1])
modelo = tf.keras.Sequential([capa])

modelo.compile(
    optimizer=tf.keras.optimizers.Adam(0.1),
    loss='mean_squared_error'
)

historial = modelo.fit(arreglo1, arreglo2, epochs=100, verbose=False)

eje.xlabel('Iteraciones')
eje.ylabel('Magnitud perdida')
eje.plot(historial.history["loss"])
