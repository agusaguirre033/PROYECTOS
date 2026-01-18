package models;

public class ProyectoDetalle {

	private int id;
	private int proyectoId;
	private int empeladoId;
	private String tarea;
	private double sueldo;

	public ProyectoDetalle() {
	}

	public ProyectoDetalle(int id, int proyectoId, int empeladoId, String tarea, double sueldo) {
		this.id = id;
		this.proyectoId = proyectoId;
		this.empeladoId = empeladoId;
		this.tarea = tarea;
		this.sueldo = sueldo;
	}

	public ProyectoDetalle(int empeladoId, String tarea, double sueldo) {
		this.empeladoId = empeladoId;
		this.tarea = tarea;
		this.sueldo = sueldo;
	}

	public double getSueldo() {
		return sueldo;
	}

	public void setSueldo(double sueldo) {
		this.sueldo = sueldo;
	}

	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public int getProyectoId() {
		return proyectoId;
	}

	public void setProyectoId(int proyectoId) {
		this.proyectoId = proyectoId;
	}

	public int getEmpeladoId() {
		return empeladoId;
	}

	public void setEmpeladoId(int empeladoId) {
		this.empeladoId = empeladoId;
	}

	public String getTarea() {
		return tarea;
	}

	public void setTarea(String tarea) {
		this.tarea = tarea;
	}

	@Override
	public String toString() {
		return "ProyectoDetalle [id=" + id + ", proyectoId=" + proyectoId + ", empeladoId=" + empeladoId + ", tarea="
				+ tarea + ", sueldo=" + sueldo + "]";
	}

}
