<%@ page import="java.sql.*, java.io.*, java.nio.file.*" %>

<%
String serviceName = request.getParameter("serviceName");
Part part = request.getPart("serviceImage");
String fileName = getSubmittedFileName(part);
String servicePriceStr = request.getParameter("servicePrice");

// Specify the path where images will be saved
String savePath = getServletContext().getRealPath("/") + File.separator + "images";

if (fileName != null && !fileName.isEmpty()) {
    try {
        File fileSaveDir = new File(savePath);
        if (!fileSaveDir.exists()) {
            fileSaveDir.mkdir();
        }

        part.write(fileSaveDir + File.separator + fileName);
    } catch (IOException e) {
        out.println("Error saving image: " + e.getMessage());
    }
}

int servicePrice = Integer.parseInt(servicePriceStr);

try {
    Class.forName("com.mysql.cj.jdbc.Driver");
    Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/sizzling", "root", "admin");

    PreparedStatement st = con.prepareStatement("INSERT INTO services (service_name, service_image, service_price) VALUES (?, ?, ?)");
    st.setString(1, serviceName);
    st.setString(2, fileName); // Save the file name (or path) to the database
    st.setInt(3, servicePrice);

    int x = st.executeUpdate();

    if (x == 1) {
        response.sendRedirect("successserviceadd.html");
    } else {
        out.println("Service Not Added");
    }
} catch (Exception e) {
    out.println("Error: " + e.getMessage());
}

// Helper method to get the submitted file name from a Part
private static String getSubmittedFileName(Part part) {
    for (String cd : part.getHeader("content-disposition").split(";")) {
        if (cd.trim().startsWith("filename")) {
            String fileName = cd.substring(cd.indexOf('=') + 1).trim().replace("\"", "");
            return fileName.substring(fileName.lastIndexOf('/') + 1).substring(fileName.lastIndexOf('\\') + 1);
        }
    }
    return null;
}
%>
