# Hyvä Themes - Drawers

Adds the possibility to add any number of off-canvas containers ("drawers") to the DOM and trigger their appearance from about anywhere.

You may know the minicart drawer that slides into the viewport from the right side when you click on the cart symbol in the header. This module decouples this functionality from the cart drawer and gives you the option to add pretty much anything into a drawer and let that slide into view whenever and however you like. 

## Intention/Advantages

The initial reason for this decoupling was the urge to make the header sticky. This resulted in both drawers (cart and mobile menu) to be really messy as they are both trapped inside the header container.

This module moves both their contents to the end of the DOM where they reside until they are needed. This results in the header being leaner and the trigger buttons are separated from the drawer. They can be placed anywhere in the content.

For convenience the drawers are now seperated into three sections: header, content and footer. For drawers sliding in from left or right they already come with the proper tailwind classes to have header and footer sticky while the content is variable in height rendering a scrollbar if needed. But this is optional.

Additional custom drawers can be added at ease, see drawer_examples.xml.

## Layout/Blocks

This module adds a new container ("drawers-container") at the end of the theme to house all drawers. 

You add your custom drawer via layout xml to your theme. See the added layout files for examples.

The two existing drawers (mobile menu and cart) are rearranged to demonstrate the usage.

The search can now be triggered from a sidebar as well.  

## Usage examples

To open, close or toggle a drawer add the shortcut functions defined in js.phtml:

```
<button @click="drawerOpen('mydrawer')">Open my custom drawer</button>
<button @click="drawerToggle('mydrawer')">Toggle my custom drawer</button>
<button @click="drawerClose('mydrawer')">Close my custom drawer</button>
<button @click="drawerCloseAll()">Close ALL drawers</button>
```