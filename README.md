# Gaming Enthusiasts Hub

## Description

This forum would provide a space for gamers to connect, share experiences, and stay updated on the latest in the gaming world. Users can discuss their favorite games, seek advice on challenging levels, share gaming news, and connect with others who share similar gaming interests.

## Table of Contents

- [Client-side Experience](/docs/ClientSide.md)
- [Logic Process](#Logic-process)
- [Design and Styles](#design-and-styles)
- [Team Members](#team-members)

## Logic Process

- When user is logged in the home page displays posts from the forums they are a part of, the left column has a list of forums they follow and a discovery section with a list of recommended forums. If not logged in the user sees posts from any forums, the left column only contains the discovery section.
- if logged in the account page lets a user edit account details, and see a list of posts they have made on various forums. If not logged in the user is redirected to the login page.
- login page is only available to users who are not already signed in, users fill in name and password to sign in to their account, or can select the option to create a new account
- Create account page provides a form with the required fields to create a new account
- forum pages have an option to join/leave the forum, depending on if the user is already a part. There is also an option to add a post to this forum. If a user is not signed in then selecting join or create post will route the user to the login page. Admins of a forum have the option to edit the rules and description on a forum and manage/ban users in the forum, these options are not visible to regular users
- Any user can view a post, only signed in users can post comments. Forum admins can remove posts or ban users from the forum directly from their posts or comments on posts. Users can remove their own posts when viewing them in a forum.

## Design and Styles

- Nav header with logo across top of page
- column on left contains navigation to forums
- block layout
- dark color scheme, using color triangle for color choices

## Team Members

- Caleb Reurink 37431970
- Richard Pillaca 96474556
- Gerard Escolano 14099378
