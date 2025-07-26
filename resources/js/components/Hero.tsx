import * as React from "react";

export default function Hero() {
    return React.createElement(
        "div",
        null,
        React.createElement(
            "h1",
            {
                style: {
                    textAlign: "center",
                    color: "orange",
                    marginTop: "50px",
                },
            },
            "Dab's Beauty Touch"
        ),
        React.createElement(
            "p",
            {
                style: {
                    textAlign: "center",
                    fontSize: "18px",
                    margin: "20px",
                },
            },
            "Flawless Results - Looking for a stylist who delivers neat, long-lasting braids? Experience the expert touch at Dab's Beauty Touch today!"
        ),
        React.createElement(
            "div",
            {
                style: { textAlign: "center", margin: "30px" },
            },
            React.createElement(
                "button",
                {
                    style: {
                        backgroundColor: "orange",
                        color: "white",
                        padding: "15px 30px",
                        border: "none",
                        borderRadius: "5px",
                        fontSize: "16px",
                    },
                },
                "Book Now"
            )
        )
    );
}
