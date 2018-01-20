Rendering Content With Templates
=================================

Extending Templates and Decoration
-------------------------------------
-We've been focusing on functionality, which is at the heart of any application, but we need to share data with the audience. So let's talk about how to render content. Earlier, we discussed the twig templating system, but barely scratched the surface of its functionality. We'll start with layouts, including how templates can be used with one another to create a complete webpage. Then we'll serve custom CSS and JavaScript through Symfony's asset control system. Finally, we'll discover how to use logic to format data passed into view templates from the controller.

Twig takes a unique approach to templating. In addition to sharing elements like a header or footer, elements can be decorated with a system of extending and overriding. Frankly, it's really similar to object-oriented inheritance, where children can selectively pick and choose what to customize. Parent templates are made up of html and blocks, which define common elements. A block is defined with a tag containing the word block, then a unique name. A block can have optional default content that won't be shown unless a child changes it in some way.

At the end, an end block tag is used. When it comes to extending a template, there's an order of operations to keep in mind. First, the base template is evaluated. Then extending child templates have the opportunity to replace blocks with content of their own. If it's not in a block, it's not getting replaced. Child templates must declare what they're extending using the extends tag, which will include the bundle, controller, and template that's being overridden, separated by colons. The target template can be found in source vendor the name of the bundle resources views name of the controller, and finally, the name of the template.

There's also a special case where the bundle and controller are omitted. This indicates that the template is in app resources views, followed by the name of the template in question. Let's see inheritance in action by switching to the IDE. We'll start with a child template and work our way up. Within the magazine bundle, open up resources views issue, and let's take a look at the index template. At the very top, there's an extends tag, which means the parent is in app resources views, and is named based on html dot twig.

Note that all the html is in a body tag named body. No other blocks are within the block body. All right, so what's in the base template? Let's close out the index twig. Mistake, let's close out the index template, and then open up app resources views, and there's just one file here based on html dot twig. There's not a lot in here at first glance, but there are several blocks. First is the title, which defaults to just welcome. Cheerful, isn't it? Then, style sheets underneath, and an asset.

We haven't seen that before, but don't worry, we'll discuss asset management in just a moment. In the body, there's a block body and a block JavaScripts. I like the best practice of putting CSS in the header, and JavaScript in the footer, and that's great for performance. Let's customize the title from the issue index. Go back to the issue index template. We're going to make a new line under the extends tag, then create a tag with a block named title. So block title. We'll close the percent, and then just say, issue list.

Close the tag using end block, and then a percent, and close. Save, then switch to a browser. Let's navigate to the issue index. So just app dot dev issue. Check out the title of the page. Instead of welcome, the default, it now says issue list. Well it's not much, but it's a start, because if you ask me, this page needs a hit of the Bootstrap stick. How would I go about adding CSS and JavaScript to the layout?

Serving Bootstrap framework with Assetic
-----------------------------------------
- One of Symfony's bundles is an asset management system named Assetic. Assets in this context refer to files like CSS, JavaScript, and images. Assetic provides a mechanism for manipulating assets before serving them in the browser. Known as filters, these changes can include minifying and combining style sheets in JavaScript files using compilers like Sass, Less, or CoffeeScript and image optimization to save bandwidth. Style sheets are included using a special style sheets tab, followed by a list of the files to include.

Paths to the files are typically relatives to the public web root and can include wild cards or the name of a specific file. If there are style sheets within a particular bundle, they can use the at vendor bundle name to specify a relative path. Assetic manages the paths to the assets and will change them upon minification and so forth, which will break the paths. To mitigate that, the CSS rewrite filter will update the paths appropriately. After all the style sheets and filters have been defined, we can close the tag. The results will need to be rendered and a special print of the asset URL within the link tag will take care of it.

At the end, there's an end style sheets tag and also an end block. It's best practice to wrap the style sheets in a block to allow children to decorate the style sheets. Similar to style sheets, JavaScript files are included with the JavaScripts tag in the template. Files are specified in the same way, but no filter is needed to take care of the renaming. Again, the result needs to be rendered, so just put the asset URL within a script tag. Close it out with an end JavaScripts tag, along with the end of the block.

If we want to use the bootstrap framework in our application, we'll need to download it. Remember how we installed Symfony using Composer, which downloaded dependencies? Well, Composer can download things from many vendors using GitHub and other repositories, and that includes bootstrap and the JavaScript library jQuery. Composer uses a file named Composer dot JSON, which defines both requirements for the project and where to get them. Let's add the bootstrap requirements to our application. Switch to an IDE. We're going to open Composer's configuration file, which is Composer dot JSON in the Symfony root.

In the require section, navigate to the last item, add a comma, and then we're going to add two new lines. The first one is for bootstrap. The syntax is start with a double quote, then the name of the GitHub account, TWBS, and then the name of the project, bootstrap, then a colon, space, and then the version number, three point two point star, which will include any minor version, three point two point one, point two, point three, and so forth, then a comma, then we're going to add jQuery for the component's account.

So, component, jQuery, colon, then we're going to use version one point nine point star. This is JSON, so no trailing comma here, and we're done. Save the file, then switch over to the terminal. From the Symfony root, type Composer update. This will ensure that we've got all of the latest dependencies, including our two new requirements, bootstrap and jQuery. After a few moments, both bootstrap and jQuery are downloaded. That was easy.

Now to actually include the files. Let's go back to the IDE. We can close Composer dot JSON and then open to base view, which is in app, resources, views, base, dot, HTML, dot, twig. Let's expand the style sheets section. We'll start by adding a new style sheets tag with a filter for CSS rewrite, and we'll just close it off in anticipation and specify the files.

For the files, we're going to use a special symbol. We'll start with single quote and then percent, kernel, dot, root, underscore, dir, percent. This is the variable kernel in the property root directory, which describes where the app kernel is. We need that for the relative directory. Unfortunately, there's no other way to explicitly specify the location of the vendor directory. After the percent, slash, then dot, dot, slash, vendor, TWBS, bootstrap, dist, CSS, bootstrap, dot, CSS.

Close that quote and then new line. Indent again, and we're going to do the same for the theme. Kernel, dot, root, underscore, dir, percent, slash, dot, dot, vendor, TWBS, bootstrap, dist, CSS, bootstrap, dash, theme, dot, CSS. What if we want to customize the CSS? Well, we can specify the location of a custom file using the at Lynda magazine bundle, slash, resources, slash, public, CSS, custom, dot, CSS.

We're going to create the file in just a moment. That's the last file, so close out the tag. Percent, close, and we'll indent that. Assetic needs to tell the browser where to get the filtered content, so we'll add a link to the style sheet. So, link, rel, equals, style sheet, then href, equals. Then we're going to print the asset, underscore, URL and close the print. Close the link tag and then close the style sheets using end style sheets.

Let's add a little bit of custom markup using bootstrap's classes to the body block. We're going to wrap it in a div with a class container, div, class, equals, container. Then copy that and paste, indent, and that looks good to me. Finally, let's add the JavaScripts in the block JavaScripts. New line, then start a tag for JavaScripts, indent, and we're going to use the kernel root directory again.

So, percent, kernel, dot, root, underscore, dir. Close the percent and slash, dot, dot, slash, vendor, components, jQuery, jQuery, dot, js, single quote, and bootstrap also has its own JavaScript. So, tab in, kernel, dot, root, dir, dot, dot, vendor, TWBS, bootstrap, dist, js, bootstrap, dot, js.

Close out the quote and close out the tag. I'll indent that back in. We'll need to remember to include the script source with asset URL, so script, src, equals, then the print, asset, underscore, URL, and then close that out and close out the script tag. That's all we need for JavaScripts, so percent and JavaScripts. Save the file. Now, for our custom script. We can close the base and create a new file in the magazine bundle in resources, public, CSS.

So, right click, go to new, cascading style sheet. We're going to just kind of call this one custom and click finish. We just delete that and just add some padding to the body. So, body, padding, dash, top, 50px, and save the file. It doesn't have to be a lot. One more step is going to be needed to make the assets visible. We're going to have to explicitly dump them, basically render them. It's possible to do this automatically, but it's off by default. Switch back to the terminal.

We're going to use the PHP, app, slash, console to call Assetic, colon, dump. Once complete, switch to a browser and reload the issue list. Looks a little different than it did before, and if we view the source, so right click, view source, the style sheets and JavaScript have been included. Close the source. Well, it's a start, but how can we really take control over this list of issues?

Accessing properties and methods from the template
----------------------------------------------------
- [Voiceover] We've got a great starting place for customizing our site using the Bootstrap framework. Let's make some changes to the Issues Index View template to take full advantage of it. So under Resources, Views, Issue, Index and we're back to our Index template. Let's start by adding the class table to the table so Bootstrap can style it. So, Records List, Space, Table. Now these headings are way too generic. Let's simplify a bit and make it a bit more human.

We don't need the internal ID, but we do need the publication name. So, let's just put it there. Publication. Next, let's combine the number and the date of publication into one column, and we'll just refer to that as an Issue. Cover and Actions can stay the same. Now for the row contents. Instead of the ID, let's get the name of the publication. So we can just delete that, and delete the hanging "A," and start a print tag. We know that we're gonna get the entity, so we can start there.

And we also know that property name is just Publication. And we know that publication has a name. We can actually specify the property of a property. Symphony entities are really easy to work with. For the Issue content, let's just combine the contents of these two cells. So, delete, space, put in a dash, put in a number sign in front of the entity number, and that looks pretty good. Now the cover can get a little extra love. We'll skip using Assetic for the image because we don't have any filters configured.

But we could use some Logic. See that "if" statement in "if entity date publication?" We can use the same format. Percent if entity dot cover, and we'll close that. Then we'll start an image tag. Image, class, equals, image dash responsive. Start a a new line. Go back a little bit. Instead of just the entity cover, we'll do source equals and then two brackets asset parenthesis entity dot, and then remember the name the name of the method that we used? Get cover web.

We can close that out and close out the brackets. Close out the image tag and then end the if statement. Percent end if. And then close percent. I don't think there's any need to make these buttons into a bulleted list. Instead, we can render these as in-line buttons using some Bootstrap classes for button. We'll start off by removing the bullet tags, back the indent, then add some classes here. Class equals BTN, BTN dash default, BTN dash access.

And copy that. And paste it into the other one as well. Down at the very end let's remove those other bullets. Bring that back, and add some classes to this link for the create a new entry as well. Class equals BTN. BTN dash default. The rest of it looks okay, but create a new entry doesn't sound very human. Let's just say new issue. Save the file, and then switch back to the browser. Reload.

Whoa, that looks way better. This is starting to look like a real product. Let's create a new issue. So scroll down to the bottom and click New Issue. This will be Issue Number Three, with a date of March 1, 2013. Choose File. This is Issue Number Three, so select that Asset. Click Open, then Create. The Issue's been created, so if we go back to the list, and we scroll down, Fantastic. We can see both the images now.

In this chapter, we've been exploring how to render content using Symphony's templating system. We started by learning how templates can be extended and decorated, which is similar to object-oriented programming. We then used Composer to install Bootstrap and added its style sheets in Javscript to Assetic, Symphony's Asset Management System. Finally, we customized the Issue List by accessing Properties and Methods through the template, adding some Logic and Bootstrap framework magic. One questions remains. Where do we go from here?

Where to go from here ? 
=========================
- We've come a long way in this course. We started by taking our first steps about learning what Symfony is, what it's used for, its architecture and layout, and how to install it. With that foundation, we created a controller whose sole purpose is to build a response. Along with organization and a custom bundle, and presentation in a view. We modeled magazine publications and issues in the database using the doctrine ORM and EntityManager. We defined and modeled the structure of forms, adding constraints, invalidation and even uploaded image files.

Finally, we took control of rendering content with templates, including using Assetic to manage assets and Bootstrap as the design framework. Is that all there is to Symfony? Of course not. Being a software developer is a constant quest for knowledge. You can never, ever learn enough. And the more you learn, the more you realize you don't know. That's awesome, honestly. Let's start with places to take this application. Having a mechanism for navigation with menus is actually pretty fundamental. But at the same time, it doesn't come out of the box in Symfony.

However, the third party, KnpMenuBundle, is a well-supported and used third party solution, offering an object-oriented interface for adding dynamic menus to an application. For media management, we've been treating images like files. Kick it up a notch with MediaBundle, which is maintained by Symfony. It's pretty minimalistic, and focuses on storing and managing images and downloading files, but will work well. At the very least, use it to add validation on image types. If you're looking for something with a bit more functionality, the SonataMediaBundle provides a much more robust solution for media management, including thumbnailing, interaction with CDNs and third-party providers, and a lot more.

What about the forms? Form rendering can be very, very granular, and can be taken down to the tiniest component of whatever design framework you elect to use. Speaking of design, preprocessing with the Assetic Media Manager is pretty much designed industry standard. Minifying style sheets in JavaScript is a best practice, and many designers are using tools like LESS and SASS to preprocess CSS to save time with logic, loops and other control structures. Use of JavaScript preprocessors like CoffeeScript also will simplify the creation of complex functional logic.

When the functionality gets to a place that you're happy with, you want to prepare the application for deployment. If you haven't already, please store your code in a source-revision control system like Git. Because tracking changes over time and having a snapshot of your application is more important than I can possibly articulate. Then, take a look at a deployment checklist. Like the ones over at symfony2-checklist.com and symfony-check.org. They'll go over the many best practice checks, and details that you'll want to consider when preparing your application for release into the wild.