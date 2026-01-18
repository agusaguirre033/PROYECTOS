<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
	pageEncoding="ISO-8859-1"%>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Creacion proyecto</title>
</head>
<body>

	<h1>Carrito de compras</h1>

	<p>
		Cliente:
		<c:out value="${logueado.nombre}" />
	</p>
	<p>
		Presupuesto: $
		<c:out value="${proyecto.presupuesto }" />
	<table border="1">
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Tarea</th>
				<th>Salario</th>
			</tr>
		</thead>
		<tbody>
			<c:forEach var="tupla" items="${proyecto.tuplas}">
				<tr>
					<td>${tupla.articulo.nombre }</td>
					<td>${tupla.cantidad}</td>
					<td>$${tupla.articulo.precio}</td>

				</tr>
			</c:forEach>

			<tr>
				<td colspan="2">Total</td>
				<td>$${proyecto.total}</td>
			</tr>
		</tbody>
	</table>

	<c:if test="${proyecto.presupuesto < proyecto.total }">
		<c:out value="El proyecto se fue de las manos!! (No alcanza la plata)" />

	</c:if>

	
	<h3>Agregar empleado</h3>
	<form action="crear" method="post">
		<input type="hidden" value="agregaremp" name="accion"> <select
			name="empleado">
			<c:forEach var="empleado" items="${empleados }">
				<option value="${empleado.id }">${empleado.nombre}-
					${empleado.sueldo }</option>
			</c:forEach>
		</select> <input name="tarea" /> <input type="submit">
	</form>
	<h3>Cambiar presupuesto</h3>
	<form action="crear" method="post">
		<input type="hidden" value="modifpre" name="accion"> <input
			name="importe" /> <input type="submit">

	</form>
	<h3>Finalizar</h3>

	<form action="crear" method="post">
		<input type="hidden" value="finalizar" name="accion"> <input
			type="submit">
	</form>

</body>
</html>