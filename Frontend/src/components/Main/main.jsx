import React from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";  // Import Bootstrap JS

const Home = () => {
  const images = [
    {
      src: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRifBRR6kTPk9AMfhOXvnwpNSB8lsHrZPGjCg&s",
      alt: "Image 1",
      title: "New Season Arrivals",
      text: "Explore our new collection for the season.",
    },
    {
      src: "https://retaildesignblog.net/wp-content/uploads/2018/11/7R9A5223-780x520.jpg",
      alt: "Image 2",
      title: "Exclusive Discounts",
      text: "Don't miss out on limited-time offers.",
    },
    {
      src: "https://www.shutterstock.com/image-photo/asian-tailor-woman-working-on-260nw-2334561339.jpg",
      alt: "Image 3",
      title: "Fresh Styles",
      text: "Upgrade your wardrobe with our fresh styles.",
    },
  ];

  return (
    <>
      <div className="hero border-1 pb-3">
        <div
          id="carouselExampleInterval"
          className="carousel slide carousel-fade"
          data-bs-ride="carousel"
        >
          <div className="carousel-inner">
            {images.map((image, index) => (
              <div
                key={index}
                className={`carousel-item ${index === 0 ? "active" : ""}`}
                data-bs-interval="2000"
              >
                <img
                  className="d-block w-100"
                  src={image.src}
                  alt={image.alt}
                  height={500}
                />
                <div className="carousel-caption d-flex align-items-center">
                  <div className="container">
                    <h5 className="card-title fs-1 text fw-lighter">
                      {image.title}
                    </h5>
                    <p className="card-text fs-5 d-none d-sm-block">
                      {image.text}
                    </p>
                  </div>
                </div>
              </div>
            ))}
          </div>
          <button
            className="carousel-control-prev"
            type="button"
            data-bs-target="#carouselExampleInterval"
            data-bs-slide="prev"
          >
            <span className="carousel-control-prev-icon" aria-hidden="true"></span>
            <span className="visually-hidden">Previous</span>
          </button>
          <button
            className="carousel-control-next"
            type="button"
            data-bs-target="#carouselExampleInterval"
            data-bs-slide="next"
          >
            <span className="carousel-control-next-icon" aria-hidden="true"></span>
            <span className="visually-hidden">Next</span>
          </button>
        </div>
      </div>
    </>
  );
};

export default Home;
