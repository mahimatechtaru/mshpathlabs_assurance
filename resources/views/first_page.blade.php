<html>
	<head>
		<title>{{__('Doctro')}}</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
        <style>

	html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video {
		margin: 0;
		padding: 0;
		border: 0;
		font-size: 100%;
		font: inherit;
		vertical-align: baseline;
	}


/* Box Model */
	body {
		background-color: #fff;
		color: #999999;
	}

	body, input, select, textarea {
		font-family: "Scope One", serif;
		font-size: 13pt;
		font-weight: 300;
		line-height: 1.65;
	}

    @media screen and (max-width: 1680px) {

        body, input, select, textarea {
            font-size: 11pt;
        }

    }

    @media screen and (max-width: 1280px) {

        body, input, select, textarea {
            font-size: 11pt;
        }

    }

    @media screen and (max-width: 980px) {

        body, input, select, textarea {
            font-size: 12pt;
        }

    }

    @media screen and (max-width: 736px) {

        body, input, select, textarea {
            font-size: 12pt;
        }

    }

    @media screen and (max-width: 480px) {

        body, input, select, textarea {
            font-size: 12pt;
        }

    }

/* Button */

	.button {
		-moz-appearance: none;
		-webkit-appearance: none;
		-ms-appearance: none;
		appearance: none;
		-moz-transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
		-webkit-transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
		-ms-transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
		transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
		border-radius: 4px;
		border: 0;
		cursor: pointer;
		display: inline-block;
		font-weight: 700;
		height: 2.85em;
		line-height: 2.95em;
		padding: 0 1.5em;
		text-align: center;
		text-decoration: none;
		white-space: nowrap;
        margin-top: 18px;
	}

    button.big,
    .button.big {
        font-size: 1.35em;
    }

    @media screen and (max-width: 480px) {

        .button {
            padding: 0;
            width: 100%;
        }

    }

	.button {
		background-color: #3498db;
		color: #fff !important;
	}
    .button:hover {
        background-color: #4aa3df;
    }

/* Banner */

	#banner {
		display: -ms-flexbox;
		-ms-flex-pack: center;
		-ms-flex-align: center;
		-moz-align-items: center;
		-webkit-align-items: center;
		-ms-align-items: center;
		align-items: center;
		display: -moz-flex;
		display: -webkit-flex;
		display: -ms-flex;
		display: flex;
		-moz-justify-content: center;
		-webkit-justify-content: center;
		-ms-justify-content: center;
		justify-content: center;
		background-image: url("../../images/banner.jpg");
		background-position: center;
		background-size: cover;
		background-repeat: no-repeat;
		border-top: 0;
		min-height: 100vh;
		height: 100vh !important;
		position: relative;
		text-align: center;
		overflow: hidden;
	}

    #banner .inner {
        -moz-transform: scale(1.0);
        -webkit-transform: scale(1.0);
        -ms-transform: scale(1.0);
        transform: scale(1.0);
        -moz-transition: opacity 1s ease, -moz-transform 1s ease;
        -webkit-transition: opacity 1s ease, -webkit-transform 1s ease;
        -ms-transition: opacity 1s ease, -ms-transform 1s ease;
        transition: opacity 1s ease, transform 1s ease;
        opacity: 1;
        position: relative;
        z-index: 2;
    }

    #banner h1 {
        font-size: 4em;
        margin-bottom: .25em;
        /* color: #FFF; */
        color: black
    }

    #banner p {
        /* color: rgba(255, 255, 255, 0.85); */
        color: black;
        font-size: 1.75em;
    }

	@-moz-keyframes more {
		0% {
			bottom: -3em;
		}

		100% {
			bottom: 0;
		}
	}

	@-webkit-keyframes more {
		0% {
			bottom: -3em;
		}

		100% {
			bottom: 0;
		}
	}

	@-ms-keyframes more {
		0% {
			bottom: -3em;
		}

		100% {
			bottom: 0;
		}
	}

	@keyframes more {
		0% {
			bottom: -3em;
		}

		100% {
			bottom: 0;
		}
	}

    #banner:before {
        -moz-transition: opacity 3s ease;
        -webkit-transition: opacity 3s ease;
        -ms-transition: opacity 3s ease;
        transition: opacity 3s ease;
        -moz-transition-delay: 1.25s;
        -webkit-transition-delay: 1.25s;
        -ms-transition-delay: 1.25s;
        transition-delay: 1.25s;
        content: '';
        display: block;
        background-color: #e1ebf5;
        height: 100%;
        left: 0;
        opacity: 0.65;
        position: absolute;
        top: 0;
        width: 100%;
        z-index: 1;
    }

    @media screen and (max-width: 980px) {

        #banner {
            font-size: .85em;
        }

            #banner br {
                display: none;
            }

    }

    @media screen and (max-width: 736px) {

        #banner {
            min-height: 0;
            padding: 8em 2em 4em 2em;
        }

            #banner .inner {
                width: 100%;
            }

            #banner h1 {
                font-size: 1.75em;
                margin-bottom: 0.5em;
                padding-bottom: 0;
            }

            #banner p {
                font-size: 1.25em;
            }

            #banner .button {
                width: 100%;
            }

    }

    @media screen and (max-width: 480px) {

        #banner p {
            font-size: 1em;
        }

    }
    </style>
	</head>
	<body>

		<!-- Banner -->
        <section id="banner">
            <div class="inner">
                <header>
                    <h1>Welcome to Doctro</h1>
                    <p>Thank you for purchasing Doctro<br />get your installation key and install database</p>
                </header>
                <a href="{{ url('/installer') }}" class="button big scrolly">Installer</a>
            </div>
        </section>
	</body>
</html>
