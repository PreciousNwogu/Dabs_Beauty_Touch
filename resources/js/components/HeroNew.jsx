import React, { useState } from "react";

// Braid style guide data
const braidStyles = [
    {
        name: "Small Knotless",
        options: [
            { label: "Shoulder", price: "$230" },
            { label: "Mid Back", price: "$260" },
            { label: "Waist Length", price: "$300" },
            { label: "Top Butt", price: "$350" },
            { label: "Mid Butt", price: "$400" },
            { label: "Under Butt", price: "$450" },
            { label: "Thigh Length", price: "$550" },
        ],
        image: require("../../images/braid4.jpg"),
    },
    {
        name: "Medium Knotless",
        options: [
            { label: "Waist Length", price: "$180" },
            { label: "Top Butt", price: "$220" },
            { label: "Mid Butt", price: "$260" },
            { label: "Under Butt", price: "$300" },
        ],
        image: require("../../images/braids.jpeg"),
    },
    {
        name: "Smedium Knotless",
        options: [
            { label: "Shoulder", price: "$200" },
            { label: "Midback", price: "$220" },
            { label: "Waist", price: "$260" },
            { label: "Top Butt", price: "$300" },
            { label: "Mid Butt", price: "$350" },
            { label: "Under Butt", price: "$400" },
            { label: "Mid Thigh", price: "$450" },
        ],
        image: require("../../images/backgroundbraidimg.jpg"),
    },
    {
        name: "Medium Knotless",
        options: [
            { label: "Starting", price: "$130" },
            { label: "Top Butt", price: "$160" },
            { label: "Mid Butt", price: "$190" },
            { label: "Under Butt", price: "$220" },
        ],
        image: require("../../images/braidstyle.jpg"),
    },
];

function BookingForm() {
    const [form, setForm] = useState({
        name: "",
        phone: "",
        style: "",
        date: "",
    });
    const [submitted, setSubmitted] = useState(false);

    function handleChange(e) {
        setForm({ ...form, [e.target.name]: e.target.value });
    }

    function handleSubmit(e) {
        e.preventDefault();
        setSubmitted(true);
        // You can add API logic here
    }

    return (
        <div
            style={{
                maxWidth: 500,
                margin: "40px auto",
                padding: 24,
                borderRadius: 12,
                boxShadow: "0 2px 12px #eee",
                background: "#fff",
            }}
        >
            <h2
                style={{
                    textAlign: "center",
                    color: "orange",
                    marginBottom: 24,
                }}
            >
                Book Appointment
            </h2>
            {submitted ? (
                <div
                    style={{
                        textAlign: "center",
                        color: "green",
                        marginBottom: 16,
                    }}
                >
                    Thank you for booking!
                </div>
            ) : null}
            <form onSubmit={handleSubmit}>
                <div style={{ marginBottom: 16 }}>
                    <label
                        style={{
                            display: "block",
                            marginBottom: 6,
                            fontWeight: 500,
                        }}
                    >
                        Full Name *
                    </label>
                    <input
                        type="text"
                        name="name"
                        value={form.name}
                        onChange={handleChange}
                        required
                        style={{
                            width: "100%",
                            padding: 8,
                            borderRadius: 6,
                            border: "1px solid #ccc",
                        }}
                    />
                </div>
                <div style={{ marginBottom: 16 }}>
                    <label
                        style={{
                            display: "block",
                            marginBottom: 6,
                            fontWeight: 500,
                        }}
                    >
                        Phone Number *
                    </label>
                    <input
                        type="tel"
                        name="phone"
                        value={form.phone}
                        onChange={handleChange}
                        required
                        style={{
                            width: "100%",
                            padding: 8,
                            borderRadius: 6,
                            border: "1px solid #ccc",
                        }}
                    />
                </div>
                {/* Style and date/time fields removed as requested */}
                <button
                    type="submit"
                    style={{
                        width: "100%",
                        backgroundColor: "orange",
                        color: "white",
                        padding: "12px 0",
                        border: "none",
                        borderRadius: 6,
                        fontWeight: 600,
                        fontSize: 16,
                        marginTop: 8,
                    }}
                >
                    Book Now
                </button>
            </form>
            <div style={{ marginTop: 32 }}>
                <h3
                    style={{
                        color: "#030f68",
                        textAlign: "center",
                        marginBottom: 18,
                    }}
                >
                    Braid Style Guide
                </h3>
                {braidStyles.map((style, idx) => (
                    <div
                        key={style.name}
                        style={{
                            marginBottom: 28,
                            border: "1px solid #eee",
                            borderRadius: 10,
                            padding: 16,
                            background: "#f8f9fa",
                        }}
                    >
                        <div style={{ display: "flex", alignItems: "center" }}>
                            <img
                                src={style.image}
                                alt={style.name}
                                style={{
                                    width: 90,
                                    height: 90,
                                    objectFit: "cover",
                                    borderRadius: 8,
                                    marginRight: 18,
                                    border: "2px solid #fff",
                                }}
                            />
                            <div>
                                <h4
                                    style={{
                                        margin: 0,
                                        color: "orange",
                                        fontWeight: 700,
                                    }}
                                >
                                    {style.name}
                                </h4>
                                <ul
                                    style={{
                                        margin: "8px 0 0 0",
                                        padding: 0,
                                        listStyle: "none",
                                    }}
                                >
                                    {style.options.map((opt) => (
                                        <li
                                            key={opt.label}
                                            style={{
                                                fontSize: 15,
                                                color: "#222",
                                                marginBottom: 2,
                                            }}
                                        >
                                            <span style={{ fontWeight: 500 }}>
                                                {opt.label}
                                            </span>
                                            :{" "}
                                            <span
                                                style={{
                                                    color: "#030f68",
                                                    fontWeight: 600,
                                                }}
                                            >
                                                {opt.price}
                                            </span>
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
}

export default BookingForm;
