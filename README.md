## General Description

this work in progress project is a upcoming MVP-Framework for Wordpress, developed by Weltenretter UG. 
it is the compiled resource of over 4 years of Wordpress template developement experience from the 
perspective of a professional software engineer and less from the perspective of a classical webdesigner/webdeveloper. 
we care more about the data aspects and how to link data in a smart, extended template than just producing webdesigns. 
this framework is for the software engineers who want to use concepts from software developement and to make the
developement of themes less contrived.

for now this will be an extension of existing frameworks and couldnt be used as a framework on its own. 
this is likely to change in the feature. right now this framework will contain every concept we 
developed to ease and streamline the process of creating extensive wordpress templates, catered to our needs.

## Basic Concept and Motivation

at a basis, this framework is right now an extension to existing MVP-like Frameworks for creating Wordpress Themes, like
Timber and Lumberjack. This project aims to streamline our approach to adding advanced features (custom fields, etc.) 
and make it possible to improve software quality with extensive test capabilities. 

the core is the concept of seperating the concerns of displaying the data through a rendering engine (mostly twig, but this framework
is engine-agnostic) and the business logic needed in more complex application domains. Also we use Models to get an abstraction of 
the data provided by wordpress and, for example, access custom fields and corresponding logic.

With using Lumberjack for the most projects, we strive to achieve a close resemblance to Laravel and the "Laravel way to PHP"
because we think this is the way to develop professional php templates at a scope that reaches the polish and functionality
of software developement in a more "classical" manner. 

this framework will be our "Launching pad" for new projects and will grow and extend over time towards a substitution for other 
MVP-Frameworks with the hope of creating wordpress templates at the same efficiency and professional architecture modern
software developement demands. 

## Developement Roadmap

v1.x

we will create extensions to the wr-wordpress-starter template that will live inside this package in the future. 
we establish new concepts to use inside the constraints of Timber and Lumberjack
we will create a framework that at its heart is also agnostic of Timber and Lumberjack
we will establish a framework that gets used cooperatively with our wp base template, which will not be framework agnostic
we test most of the stuff that isnt dependent on a specific implementation before even consider adding wordpress 
into the execution context

v2.x 

eventually we will create our own framework, because the extensions and new concepts will surpass the 
functions we need from the framework. following the basis of lumberjack we will create a framework
that tries to mimick Laravel albeit beeing a bit more opinionated and catered to our development needs.