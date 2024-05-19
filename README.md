# Natas-15-16
La vulnerabilidad se trata de una inyeccion sql donde en campos como el de esta ejercisio
se realizan consultas sql con la setencia LIKE BINARY y el % que busca coincidencias en la conraseña 
almacenda en la base de datos 

Para su mitigacion se debera validar lo que el usuario ingrese en los campos por lo que solo esta permitido 
ingresar letras y numeros para localizar el usuiario ,palabras como LIKE , BETWEEN , IN etc esten bloquedas 
en campos que el usuario utiliza como es el caso 
