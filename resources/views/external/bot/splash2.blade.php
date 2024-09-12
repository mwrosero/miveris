<div class="containerSplash palette-1">
	<div class="blobs">
		<svg viewbox="0 0 1200 1200">
			<g class="blob blob-1">
				<path />
			</g>
			<g class="blob blob-2">
				<path />
			</g>
			<g class="blob blob-3">
				<path />
			</g>
			<g class="blob blob-4">
				<path />
			</g>
			<g class="blob blob-1 alt">
				<path />
			</g>
			<g class="blob blob-2 alt">
				<path />
			</g>
			<g class="blob blob-3 alt">
				<path />
			</g>
			<g class="blob blob-4 alt">
				<path />
			</g>
		</svg>
	</div>
</div>
<style id="INLINE_PEN_STYLESHEET_ID">
    h1 {
	  width: 100px;
	  position: absolute;
	  left: 0;
	  right: 0;
	  color: #fff;
	  top: 0;
	  bottom: 0;
	  margin: auto;
	}

	.containerSplash,
	.palette-1 {
	  --bg-0: #101030;
	  --bg-1: #050515;
	  --blob-1: #984ddf;
	  --blob-2: #4344ad;
	  --blob-3: #74d9e1;
	  --blob-4: #050515;
	}

	.palette-2 {
	  --bg-0: #545454;
	  --bg-1: #150513;
	  --blob-1: #ff3838;
	  --blob-2: #ff9d7c;
	  --blob-3: #ffdda0;
	  --blob-4: #fff6ea;
	}

	.palette-3 {
	  --bg-0: #300030;
	  --bg-1: #000000;
	  --blob-1: #291528;
	  --blob-2: #3a3e3b;
	  --blob-3: #9e829c;
	  --blob-4: #f0eff4;
	}

	.palette-4 {
	  --bg-0: #ffffff;
	  --bg-1: #d3f7ff;
	  --blob-1: #bb74ff;
	  --blob-2: #7c7dff;
	  --blob-3: #a0f8ff;
	  --blob-4: #ffffff;
	}

	.palette-5 {
	  --bg-0: #968e85;
	  --bg-1: #8cc084;
	  --blob-1: #c1d7ae;
	  --blob-2: #9eff72;
	  --blob-3: #ffcab1;
	  --blob-4: #ecdcb0;
	}

	.palette-6 {
	  --bg-0: #ffffff;
	  --bg-1: #4e598c;
	  --blob-1: #ff8c42;
	  --blob-2: #fcaf58;
	  --blob-3: #f9c784;
	  --blob-4: #ffffff;
	}

	#splash{
		position: fixed;
		width: 100%;
		height: 100%;
		z-index: 9;
	}

	.containerSplash {
	  background: #0a2240;
	  width: 100%;
	  height: 100%;
	  overflow: hidden;
	  display: flex;
	  align-items: center;
	  justify-content: center;
	  transition: background 1000ms ease;
	}
	.containerSplash::after {
	  position: absolute;
	  content: "";
	  width: min(50vw, 50vh);
	  height: min(50vw, 50vh);
	  background: var(--bg-0);
	  border-radius: 50%;
	  filter: blur(10rem);
	  transition: background 500ms ease;
	}

	.blobs {
	  width: min(60vw, 60vh);
	  height: min(60vw, 60vh);
	  max-height: 100%;
	  max-width: 100%;
	}
	.blobs svg {
	  position: relative;
	  height: 100%;
	  z-index: 2;
	}
	.blobs .blob {
	  animation: rotate 5s infinite alternate ease-in-out;
	  transform-origin: 50% 50%;
	  opacity: 0.7;
	}
	.blobs .blob path {
	  animation: blob-anim-1 3s infinite alternate cubic-bezier(0.45, 0.2, 0.55, 0.8);
	  transform-origin: 50% 50%;
	  transform: scale(0.8);
	  transition: fill 800ms ease;
	}
	.blobs .blob.alt {
	  animation-direction: alternate-reverse;
	  opacity: 0.3;
	}
	.blobs .blob-1 path {
	  fill: var(--blob-1);
	  filter: blur(1rem);
	}
	.blobs .blob-2 {
	  animation-duration: 3s;
	  animation-direction: alternate-reverse;
	}
	.blobs .blob-2 path {
	  fill: var(--blob-2);
	  animation-name: blob-anim-2;
	  animation-duration: 4s;
	  filter: blur(0.75rem);
	  transform: scale(0.78);
	}
	.blobs .blob-2.alt {
	  animation-direction: alternate;
	}
	.blobs .blob-3 {
	  animation-duration: 6s;
	}
	.blobs .blob-3 path {
	  fill: var(--blob-3);
	  animation-name: blob-anim-3;
	  animation-duration: 7s;
	  filter: blur(0.5rem);
	  transform: scale(0.76);
	}
	.blobs .blob-4 {
	  animation-duration: 9s;
	  animation-direction: alternate-reverse;
	  opacity: 0.9;
	}
	.blobs .blob-4 path {
	  fill: var(--blob-4);
	  animation-name: blob-anim-4;
	  animation-duration: 10s;
	  filter: blur(10rem);
	  transform: scale(0.5);
	}
	.blobs .blob-4.alt {
	  animation-direction: alternate;
	  opacity: 0.8;
	}
	@keyframes blob-anim-1 {
	  0% {
	    d: path("M 100 600 q 0 -500, 500 -500 t 500 500 t -500 500 T 100 600 z");
	  }
	  30% {
	    d: path("M 100 600 q -50 -400, 500 -500 t 450 550 t -500 500 T 100 600 z");
	  }
	  70% {
	    d: path("M 100 600 q 0 -400, 500 -500 t 400 500 t -500 500 T 100 600 z");
	  }
	  100% {
	    d: path("M 150 600 q 0 -600, 500 -500 t 500 550 t -500 500 T 150 600 z");
	  }
	}
	@keyframes blob-anim-2 {
	  0% {
	    d: path("M 100 600 q 0 -400, 500 -500 t 400 500 t -500 500 T 100 600 z");
	  }
	  40% {
	    d: path("M 150 600 q 0 -600, 500 -500 t 500 550 t -500 500 T 150 600 z");
	  }
	  80% {
	    d: path("M 100 600 q -50 -400, 500 -500 t 450 550 t -500 500 T 100 600 z");
	  }
	  100% {
	    d: path("M 100 600 q 100 -600, 500 -500 t 400 500 t -500 500 T 100 600 z");
	  }
	}
	@keyframes blob-anim-3 {
	  0% {
	    d: path("M 100 600 q -50 -400, 500 -500 t 450 550 t -500 500 T 100 600 z");
	  }
	  35% {
	    d: path("M 150 600 q 0 -600, 500 -500 t 500 550 t -500 500 T 150 600 z");
	  }
	  75% {
	    d: path("M 100 600 q 100 -600, 500 -500 t 400 500 t -500 500 T 100 600 z");
	  }
	  100% {
	    d: path("M 100 600 q 0 -400, 500 -500 t 400 500 t -500 500 T 100 600 z");
	  }
	}
	@keyframes blob-anim-4 {
	  0% {
	    d: path("M 150 600 q 0 -600, 500 -500 t 500 550 t -500 500 T 150 600 z");
	  }
	  30% {
	    d: path("M 100 600 q 100 -600, 500 -500 t 400 500 t -500 500 T 100 600 z");
	  }
	  70% {
	    d: path("M 100 600 q -50 -400, 500 -500 t 450 550 t -500 500 T 100 600 z");
	  }
	  100% {
	    d: path("M 150 600 q 0 -600, 500 -500 t 500 550 t -500 500 T 150 600 z");
	  }
	}
	@keyframes rotate {
	  from {
	    transform: rotate(0deg);
	  }
	  to {
	    transform: rotate(360deg);
	  }
	}

	.switcher {
	  position: absolute;
	  left: 1rem;
	  top: 0;
	  height: 100vh;
	  display: flex;
	  flex-direction: column;
	  justify-content: center;
	  gap: 1rem;
	}
	.switcher .switch-button {
	  cursor: pointer;
	  width: min(10vh, 5rem);
	  height: min(10vh, 5rem);
	  background: red;
	  background: radial-gradient(var(--bg-0), var(--bg-1));
	  border-radius: 0.5rem;
	  backdrop-filter: blur(1rem);
	  border: 1px solid rgba(120, 120, 120, 0.5);
	}
</style>
<script>
	document.addEventListener("DOMContentLoaded", () => {
		const containerSplash = document.querySelector(".containerSplash");
		const blobs = document.querySelector(".blobs");
		const switchButtons = document.querySelectorAll(".switch-button");

		switchButtons.forEach((button) => {
			button.append(blobs.cloneNode(true));
			button.addEventListener("click", () => {
				console.log(button);
				containerSplash.classList = `containerSplash palette-${button.dataset.palette}`;
			});
		});
	});
</script>