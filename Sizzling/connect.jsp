<%@ page import = "java.sql.*" %>



<%
String username = request.getParameter("name");
String password = request.getParameter("password");
String email = request.getParameter("email");
String phone = request.getParameter("phone");
String address = request.getParameter("address");
String city = request.getParameter("city");

try
{
Class.forName("com.mysql.cj.jdbc.Driver");
Connection
con=DriverManager.getConnection("jdbc:mysql://localhost:3306/sizzling", "root","admin");

PreparedStatement st = (PreparedStatement)
con.prepareStatement("INSERT INTO registration (Uname, Upassword, Uemail, Umobile, Uaddress, Ucity) VALUES (?, ?, ?, ?, ?, ?)");
st.setString(1, username);
st.setString(2, password);
st.setString(3, email);
st.setString(4, phone);
st.setString(5, address);
st.setString(6, city);

int x = st.executeUpdate();

if(x==1){
	out.println("Registration Successful");
	response.sendRedirect("login.html");
}
else{
	out.println("Registration Failed");
}
}
catch(Exception e) {}

%>