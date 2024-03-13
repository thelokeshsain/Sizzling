<%@ page import="com.itextpdf.text.Document" %>
<%@ page import="com.itextpdf.text.Paragraph" %>
<%@ page import="com.itextpdf.text.pdf.PdfWriter" %>
<%@ page import="java.io.ByteArrayOutputStream" %>

<%
String service = request.getParameter("service");
String date = request.getParameter("date");
String time = request.getParameter("time");

try (Document document = new Document()) {
    ByteArrayOutputStream baos = new ByteArrayOutputStream();
    PdfWriter.getInstance(document, baos);
    document.open();
    document.add(new Paragraph("Sizzling Hair Salon"));
    document.add(new Paragraph("Appointment Receipt"));
    document.add(new Paragraph("Service: " + service));
    document.add(new Paragraph("Date: " + date));
    document.add(new Paragraph("Time: " + time));
    document.close();

    response.setContentType("application/pdf");
    response.setContentLength(baos.size());
    response.setHeader("Content-disposition", "attachment; filename=receipt.pdf");
    response.getOutputStream().write(baos.toByteArray());
}
%>
