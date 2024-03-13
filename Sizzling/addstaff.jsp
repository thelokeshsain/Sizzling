<%@ page import = "java.sql.*" %>



<%
String StaffName = request.getParameter("staffname");
String StaffPost = request.getParameter("staffpost");
String StaffContact = request.getParameter("staffcontact");
String StaffAbout = request.getParameter("staffabout");
try
{
Class.forName("com.mysql.cj.jdbc.Driver");
Connection
con=DriverManager.getConnection("jdbc:mysql://localhost:3306/sizzling", "root","admin");

PreparedStatement st = (PreparedStatement)
con.prepareStatement("INSERT INTO staff (sname,spost,sabout,scontact) VALUES (?, ?, ?, ?)");
st.setString(1, StaffName);
st.setString(2, StaffPost);
st.setString(3, StaffAbout);
st.setString(4, StaffContact);

int x = st.executeUpdate();

if(x==1){
	response.sendRedirect("Staffdetail.jsp");
}
else{
	out.println("Staff Not Added");
}
}
catch(Exception e) {}

%>