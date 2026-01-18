package controllers;


import java.io.IOException;
import java.util.List;
import java.util.Optional;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;


import models.Articulo;

import repositories.ArticulosRepoSingleton;



@WebServlet("/articulos")
public class ArticulosController extends HttpServlet {
	private static final long serialVersionUID = 1L;
       
    private ArticulosRepoSingleton articulosRepo;
    
    public ArticulosController() {
        this.articulosRepo = ArticulosRepoSingleton.getInstance();
    }
   
	
	protected void doGet(HttpServletRequest request, HttpServletResponse response) 
			throws ServletException, IOException {
		
//		HttpSession session = request.getSession(false);
//		if (session == null || session.getAttribute("usuario") == null){
//		
//			response.sendRedirect("auth");
//			return;
//		}
//		
//		Usuario usuario = (Usuario) session.getAttribute("usuario");
		
		String accion = request.getParameter("accion");
		accion = Optional.ofNullable(accion).orElse("index");
		
		switch (accion) {
		case "index" -> getIndex(request,response);
		case "show" -> getShow(request,response);
		case "edit" -> getEdit(request,response);
		case "create" -> getCreate(request,response);
		
		default -> response.sendError(404, "No existe la accion: " + accion);
		}
		
	}
    
	


	private void getCreate(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		
		request.getRequestDispatcher("/views/articulos/create.jsp").forward(request, response);
	}


	private void getEdit(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		
		
		String sId = request.getParameter("id");
		
		int id = Integer.parseInt(sId);
		
		
		Articulo art = articulosRepo.findById(id);
		
		request.setAttribute("articulo", art);
		request.getRequestDispatcher("/views/articulos/edit.jsp").forward(request, response);
			
		
	}


	private void getShow(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		
		String sId = request.getParameter("id");
		int id = Integer.parseInt(sId);
		
		Articulo art = articulosRepo.findById(id);
		request.setAttribute("articulo", art);
		request.getRequestDispatcher("/views/articulos/show.jsp").forward(request, response);
	}


	private void getIndex(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
	    
	
//		HttpSession session = request.getSession(false);
//		if (session != null) {
//			
//			Usuario usuario = (Usuario) session.getAttribute("usuario");
//		}
		
		List<Articulo> articulos = articulosRepo.getAll();
		request.setAttribute("inventario", articulos);
		
		
		request.getRequestDispatcher("/views/articulos/index.jsp").forward(request, response);//enviando a la direccion index
	
	}
	

	protected void doPost(HttpServletRequest request, HttpServletResponse response) 
			throws ServletException, IOException {
		
		String accion = request.getParameter("accion");
	
		if(accion == null) {
			response.sendError(400, "Nose brindó una acción");
			return;
		}
		 
		switch (accion) {
		case "insert" -> postInsert(request,response);
		case "update" -> postUpdate(request,response);
		case "delete" -> postDelete(request,response);
		default -> response.sendError(404, "No existe la accion: " + accion);
		}
	
	}


	private void postUpdate(HttpServletRequest request, HttpServletResponse response) throws IOException {
		
		String sId =request.getParameter("id");
		int id = Integer.parseInt(sId);
		
		String codigo = request.getParameter("codigo");
		String titulo = request.getParameter("titulo");
		String autor = request.getParameter("autor");
		String sAño = request.getParameter("año");
		int año = Integer.parseInt(sAño);
		String editorial = request.getParameter("editorial");
		String categoria = request.getParameter("categoria");
		String sPrecio = request.getParameter("precio");
		double precio = Double.parseDouble(sPrecio);
		String sStock = request.getParameter("stock");
		int stock = Integer.parseInt(sStock);
		
		Articulo art = articulosRepo.findById(id);
		art.setCodigo(codigo);
		art.setTitulo(titulo);
		art.setAutor(autor);
		art.setAño(año);
		art.setEditorial(editorial);
		art.setCategoria(categoria);
		art.setPrecio(precio);
		art.setStock(stock);

		articulosRepo.update(art);
		
		response.sendRedirect("articulos");
	}


	private void postDelete(HttpServletRequest request, HttpServletResponse response) throws IOException {
		String sId =request.getParameter("id");
		int id = Integer.parseInt(sId);
		
		articulosRepo.delete(id);
		
		response.sendRedirect("articulos");
		
	}


	private void postInsert(HttpServletRequest request, HttpServletResponse response)throws IOException {
		
		String codigo = request.getParameter("codigo");
		String titulo = request.getParameter("titulo");
		String autor = request.getParameter("autor");
		String sAño = request.getParameter("año");
		int año = Integer.parseInt(sAño);
		String editorial = request.getParameter("editorial");
		String categoria = request.getParameter("categoria");
		String sPrecio = request.getParameter("precio");
		double precio = Double.parseDouble(sPrecio);
		String sStock = request.getParameter("stock");
		int stock = Integer.parseInt(sStock);
		
		
		Articulo art = new Articulo();
		art.setCodigo(codigo);
		art.setTitulo(titulo);
		art.setAutor(autor);
		art.setAño(año);
		art.setEditorial(editorial);
		art.setCategoria(categoria);
		art.setPrecio(precio);
		art.setStock(stock);
		
		articulosRepo.insert(art);
		response.sendRedirect("articulos");
		
	}

}
