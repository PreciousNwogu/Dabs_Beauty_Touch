import React from "react";

function Hero() {
    return (
        <div>
            <h1
                style={{
                    textAlign: "center",
                    color: "orange",
                    marginTop: "50px",
                }}
            >
                Dab&apos;s Beauty Touch
            </h1>
            <p
                style={{
                    textAlign: "center",
                    fontSize: "18px",
                    margin: "20px",
                }}
            >
                Flawless Results - Looking for a stylist who delivers neat,
                long-lasting braids? Experience the expert touch at Dab&apos;s
                Beauty Touch today!
            </p>
            <div style={{ textAlign: "center", margin: "30px" }}>
                <button
                    style={{
                        backgroundColor: "orange",
                        color: "white",
                        padding: "15px 30px",
                        border: "none",
                        borderRadius: "5px",
                        fontSize: "16px",
                    }}
                >
                    Book Now
                </button>
            </div>
        </div>
    );
}

export default Hero;
