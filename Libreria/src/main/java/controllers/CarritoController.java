package controllers;

import java.io.IOException;
import java.util.List;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

import decorators.SessionDecorator;
import exceptions.UsuarioDeslogueadoException;
import exceptions.PresupuestoExcedidoException;

import models.Articulo;
import models.Proyecto;
import models.ProyectoDetalle;
import models.Usuario;
import repositories.ArticulosRepoSingleton;
import repositories.UsuariosRepoSingleton;
import repositories.interfaces.ArticuloRepo;
import utils.Carrito;

@WebServlet("/crear")
public class CarritoController extends HttpServlet {
	private static final long serialVersionUID = 1L;
	
    private ArticulosRepoSingleton articulosRepo;
    private UsuariosRepoSingleton usuariosRepo;
    
//    public void ArticulosController() throws IOException {
//        this.articulosRepo = ArticulosRepoSingleton.getInstance();
//        this.usuariosRepo = UsuariosRepoSingleton.getInstance();
//    }
    
 

	@Override
	protected void doGet(HttpServletRequest request, HttpServletResponse response)
			throws ServletException, IOException {

		HttpSession session = request.getSession();

		SessionDecorator sessionDec = new SessionDecorator(session);

		try {
			Usuario usuarioActualizado = sessionDec.getUsuarioLogueadoActu(usuariosRepo);

			Carrito proyecto = sessionDec.getProyecto();

			// proyecto.setLider(empleadoActualizado);

			List<Articulo> articulos = articulosRepo.getAll();

			request.setAttribute("proyecto", proyecto);
			request.setAttribute("logueado", usuarioActualizado);
			request.setAttribute("empleados", articulos);

			request.getRequestDispatcher("/views/carrito/index.jsp")
					.forward(request, response);

		} catch (UsuarioDeslogueadoException e) {
			response.sendRedirect("auth");
			return;
		}
	}

	@Override
	protected void doPost(HttpServletRequest request, HttpServletResponse response)
			throws ServletException, IOException {

		String accion = request.getParameter("accion");
		try {
			switch (accion) {
			case "modifpre" -> postModificarPresupuesto(request, response);
			case "agregaremp" -> postAgregarEmpleado(request, response);
			case "finalizar" -> postFinalizar(request, response);
			default -> response.sendError(404);
			}
		} catch (UsuarioDeslogueadoException e) {
			response.sendRedirect("auth");
		} catch (PresupuestoExcedidoException e) {
			response.sendError(400, e.getMessage());
		}

	}

	private void postFinalizar(HttpServletRequest request, HttpServletResponse response)
			throws UsuarioDeslogueadoException, IOException, PresupuestoExcedidoException {

		SessionDecorator sDec = new SessionDecorator(request.getSession());

		Usuario usu = sDec.getUsuarioLogueadoActu(usuariosRepo);
		Carrito proBuilder = sDec.getProyecto();

		Proyecto pro = proBuilder.toProyecto((ArticuloRepo) usuariosRepo, usu.getId());//casteo NO SE SI VA

		sDec.removeProyecto();

		var w = response.getWriter();

		w.append(pro.toString()).append("\n");
		for (ProyectoDetalle detalle : pro.getPersonal()) {
			w.append(detalle.toString()).append("\n");
		}

		// TODO Guardar en la base de datos

	}

	private void postAgregarEmpleado(HttpServletRequest request, HttpServletResponse response) throws IOException {

		String sEmpleadoId = request.getParameter("empleado");
		int empeadoId = Integer.parseInt(sEmpleadoId);
		String tarea = request.getParameter("tarea");
        
		
		SessionDecorator sDec = new SessionDecorator(request.getSession());

		Carrito proyecto = sDec
				.getProyecto();

		Articulo art = articulosRepo.findById(empeadoId);

		proyecto.agregarTupla(art, , tarea);

		response.sendRedirect("crear");

	}

	private void postModificarPresupuesto(HttpServletRequest request, HttpServletResponse response)
			throws IOException, UsuarioDeslogueadoException {

		HttpSession session = request.getSession();

		SessionDecorator sessionDec = new SessionDecorator(session);

		Carrito proyecto = sessionDec.getProyecto();

		String sImporte = request.getParameter("importe");

		double importe = Double.parseDouble(sImporte);

		proyecto.setPresupuesto(importe);

		response.sendRedirect("crear");

	}

}
