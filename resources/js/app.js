import "./bootstrap";
import Alpine from "alpinejs";
import "flowbite";

if ("serviceWorker" in navigator) {
	navigator.serviceWorker
		.register("/sw.js", {
			scope: "/",
		})
		.then((registration) => {
			console.log("SW Registered!");
			console.log(registration);
		})
		.catch((error) => {
			console.log("SW Registration Failed!");
			console.log(error);
		});
}

window.Alpine = Alpine;

Alpine.start();
