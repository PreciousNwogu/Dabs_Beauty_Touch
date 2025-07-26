function Services() {
  return (
    <div style={{ padding: '50px', backgroundColor: '#fff', textAlign: 'center' }}>
      <h1 style={{ color: 'orange', marginBottom: '30px' }}>Our Services</h1>
      <div style={{ display: 'flex', justifyContent: 'center', flexWrap: 'wrap', gap: '30px' }}>
        <div style={{ 
          border: '1px solid #ddd', 
          borderRadius: '10px', 
          padding: '20px', 
          width: '250px',
          boxShadow: '0 2px 5px rgba(0,0,0,0.1)'
        }}>
          <h3 style={{ color: 'orange' }}>Braiding</h3>
          <p>Professional braiding services including box braids, cornrows, and protective styles</p>
        </div>
        <div style={{ 
          border: '1px solid #ddd', 
          borderRadius: '10px', 
          padding: '20px', 
          width: '250px',
          boxShadow: '0 2px 5px rgba(0,0,0,0.1)'
        }}>
          <h3 style={{ color: 'orange' }}>Hair Extensions</h3>
          <p>High-quality hair extensions and installation for length and volume</p>
        </div>
        <div style={{ 
          border: '1px solid #ddd', 
          borderRadius: '10px', 
          padding: '20px', 
          width: '250px',
          boxShadow: '0 2px 5px rgba(0,0,0,0.1)'
        }}>
          <h3 style={{ color: 'orange' }}>Wig Installation</h3>
          <p>Professional wig fitting and styling for a natural, flawless look</p>
        </div>
        <div style={{ 
          border: '1px solid #ddd', 
          borderRadius: '10px', 
          padding: '20px', 
          width: '250px',
          boxShadow: '0 2px 5px rgba(0,0,0,0.1)'
        }}>
          <h3 style={{ color: 'orange' }}>Hair Care</h3>
          <p>Deep conditioning treatments and hair maintenance services</p>
        </div>
      </div>
    </div>
  );
}

export default Services;