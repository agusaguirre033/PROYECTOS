package models;

import java.util.ArrayList;
import java.util.List;

public class Proyecto {

	private int id;
	private int liderId;
	private double presupuesto;
	private double total;

	// Relacion:
	private List<ProyectoDetalle> personal;

	public Proyecto() {
		this.personal = new ArrayList<ProyectoDetalle>();
	}

	public Proyecto(int liderId, double presupuesto, double total) {
		this();
		this.liderId = liderId;
		this.presupuesto = presupuesto;
		this.total = total;
	}

	public void addPersonal(int articuloId, String cantidad, double precio) {
		this.personal.add(new ProyectoDetalle(articuloId, cantidad, precio));
	}

	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public int getLiderId() {
		return liderId;
	}

	public void setLiderId(int liderId) {
		this.liderId = liderId;
	}

	public double getPresupuesto() {
		return presupuesto;
	}

	public void setPresupuesto(double presupuesto) {
		this.presupuesto = presupuesto;
	}

	public double getTotal() {
		return total;
	}

	public void setTotal(double total) {
		this.total = total;
	}

	public List<ProyectoDetalle> getPersonal() {
		return personal;
	}

	@Override
	public String toString() {
		return "Proyecto [id=" + id + ", liderId=" + liderId + ", presupuesto=" + presupuesto + ", total=" + total
				+ "]";
	}

}
