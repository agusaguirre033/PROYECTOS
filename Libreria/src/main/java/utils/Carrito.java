package utils;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.Optional;

import exceptions.PresupuestoExcedidoException;
import models.Articulo;
import models.Proyecto;
import models.Usuario;
import repositories.interfaces.ArticuloRepo;
import repositories.interfaces.UsuarioRepo;

public class Carrito {

	public class Tupla {
		private Articulo articulo;
		private Usuario usuario;
		private String cantidad;

		public double getPrecio() {
			return Optional.ofNullable(articulo)
					.map(Articulo::getPrecio)
					.orElse(0.0);
		}

		public Tupla(Articulo art, Usuario usu, String cantidad) {
			this.articulo = art;
			this.usuario = usu;
			this.cantidad = cantidad;
		}

		public Articulo getArticulo() {
			return articulo;
		}
		
		public Usuario getUsuario() {
			return usuario;
		}

		public void setArticulo(Articulo articulo) {
			this.articulo = articulo;
		}
		
		public void setUsuario(Usuario usuario) {
			this.usuario = usuario;
		}

		public String getCantidad() {
			return cantidad;
		}

		public void setCantidad(String cantidad) {
			this.cantidad = cantidad;
		}

		


	}

	// private Empleado lider;
	private double presupuesto;
	private List<Carrito.Tupla> tuplas;

	public double getTotal() {
		double total = this.tuplas.stream()
				.mapToDouble(Tupla::getPrecio)
				.sum();

		return total;

	}

	public Carrito() {
		this.presupuesto = 0;
		this.tuplas = new ArrayList<Carrito.Tupla>();
	}

	public void agregarTupla(Articulo art, Usuario usu, String cantidad) {
		this.tuplas.add(new Carrito.Tupla(art, usu, cantidad));
	}

	public List<Carrito.Tupla> getTuplas() {
		return tuplas;
	}

	public double getPresupuesto() {
		return presupuesto;
	}

	public void setPresupuesto(double presupuesto) {
		this.presupuesto = presupuesto;
	}

	public Proyecto toProyecto(ArticuloRepo aRepo, int liderId) throws IOException, PresupuestoExcedidoException {

		Proyecto proyecto = new Proyecto(liderId, this.presupuesto, this.getTotal());

		for (Tupla tupla : tuplas) {

		Articulo art = aRepo.findById(tupla.getArticulo().getId());

			tupla.setArticulo(art);

			proyecto.addPersonal(art.getId(), tupla.getCantidad(), art.getPrecio());
			
		}

		if (this.presupuesto < this.getTotal()) {
			throw new PresupuestoExcedidoException("Se ha superado el presupuesto");
		}

		return proyecto;
	}

}
