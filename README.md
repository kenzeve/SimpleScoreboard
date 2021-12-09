Simple PM4 scoreboard library for per-player use

## Create and send lines

```php
$scoreboard = new Scoreboard($player);
$scoreboard->create("Title");
$scoreboard->setLine(1, "Text 1");
$scoreboard->setLine(2, "Text 2");
$scoreboard->setLine(3, "Text 3");
```
## Update

```php
$scoreboard->create("New Title");
$scoreboard->setLine(1, "New Text 1");
$scoreboard->setLine(2, "New Text 2");
$scoreboard->setLine(3, "New Text 3");
```
## Remove

```php
$scoreboard->remove();
```
