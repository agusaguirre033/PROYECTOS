package models;

public class Articulo {

	private int id;
	private String codigo;
	private String titulo;
	private String autor;
	private int año;
	private String editorial;
	private String categoria;
	private double precio;
	private int stock;
	
	public Articulo(String codigo, String titulo, String autor, int año, String editorial, String categoria,
			double precio, int stock) {
		super();
		this.codigo = codigo;
		this.titulo = titulo;
		this.autor = autor;
		this.año = año;
		this.editorial = editorial;
		this.categoria = categoria;
		this.precio = precio;
		this.stock = stock;
	}

	public Articulo() {
		super();
	}

	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public String getCodigo() {
		return codigo;
	}

	public void setCodigo(String codigo) {
		this.codigo = codigo;
	}

	public String getTitulo() {
		return titulo;
	}

	public void setTitulo(String titulo) {
		this.titulo = titulo;
	}

	public String getAutor() {
		return autor;
	}

	public void setAutor(String autor) {
		this.autor = autor;
	}

	public int getAño() {
		return año;
	}

	public void setAño(int año) {
		this.año = año;
	}

	public String getEditorial() {
		return editorial;
	}

	public void setEditorial(String editorial) {
		this.editorial = editorial;
	}

	public String getCategoria() {
		return categoria;
	}

	public void setCategoria(String categoria) {
		this.categoria = categoria;
	}

	public double getPrecio() {
		return precio;
	}

	public void setPrecio(double precio) {
		this.precio = precio;
	}

	public int getStock() {
		return stock;
	}

	public void setStock(int stock) {
		this.stock = stock;
	}

	@Override
	public String toString() {
		return "Articulo [id=" + id + ", codigo=" + codigo + ", titulo=" + titulo + ", autor=" + autor + ", año=" + año
				+ ", editorial=" + editorial + ", categoria=" + categoria + ", precio=" + precio + ", stock=" + stock
				+ "]";
	}

	
	
	

}
