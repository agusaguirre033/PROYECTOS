package models;

public class Usuario {
	
	private int id;
	private String nombre;
    private String password;
    private String rol;
    private double presupuesto;
    
    
	public Usuario(String nombre, String password, String rol, double presupuesto) {
		super();
		this.nombre = nombre;
		this.password = password;
		this.rol = rol;
		this.presupuesto = presupuesto;
	}


	public Usuario() {
		super();
	}


	public int getId() {
		return id;
	}


	public void setId(int id) {
		this.id = id;
	}


	public String getNombre() {
		return nombre;
	}


	public void setNombre(String nombre) {
		this.nombre = nombre;
	}


	public String getPassword() {
		return password;
	}


	public void setPassword(String password) {
		this.password = password;
	}


	public String getRol() {
		return rol;
	}


	public void setRol(String rol) {
		this.rol = rol;
	}


	public double getPresupuesto() {
		return presupuesto;
	}


	public void setPresupuesto(double presupuesto) {
		this.presupuesto = presupuesto;
	}
    
    
    
    
}
