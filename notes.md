# Media Buyer Notes

### One Admin Account
Username: `robw`
Password: `rwatt`

### Two Media Buyer Accounts
#### Rob Johnson Group
Username: `steph`
Password: `steph1`

*Wordpress Login:*
Username: `rojo`
Password: `getfuck3d`

#### Formula Swiss
Username: `steph_swiss`
Password: `steph1`

## Page Setup 

### Add URL
- Go to Server Manager
- Build Server
- Choose a relevant URL for the offer you are using
- Select packages (lander pages that rob makes)
- Click "Build"
- Wait for that to finish (15 - 20 minutes)
  - You can refresh the page to see progress

### On Wordpress
- Go to the URL you entered in the last step
- Add `/wp-admin` to the end of the url
- Find the credentials
 - 1. Log into Rob's account (top of page)
 - 2. Use the account switcher to select Rob Johnson Group or Formula Swiss depending on where you added the URL
  - Admin Panel > Switch Group
  - Select Group Name, click Submit
 - 2. Go to Server Manager > Configure
 - 3. Look at the Wordpress tab
 - 4. Use the Login/Password on the wordpress login page
- Customize wordpress site (customize theme, etc.)
- Create a wordpress Post
- Activate KowboyKit plugin under settings
  - Copy/paste in the URL of the wordpress post you just made
- Go to the URL you pasted in, it should redirect you to the KowboyKit Add New Lander page

### On KowboyKit
- Choose a title for your lander
- Select the type/offer
- Use the Account info you are given
- Don't change any checkboxes
- Hit Submit

### In Lander Manager
- When your lander hits about 100 clicks that means Facebook is done reviewing and you can do the following:
- Select your lander from the list
- Click on "Cloaker" in the top right
- Change the Cloaker status to Active

#### Page Setup Complete!


### Facebook Ad Setup
- facebook.com > arrow in top right > click ads manager
 - you should already be logged in when using team viewer

- Create new Campaign
- Always select "Conversions"
- Always name everything (ads, etc.) aka replace the default name
- Choose your audience
 - Age range
 - Gender
- Generally keep the targeting broad

####Set the daily budget *IMPORTANT*
This is something that you want to watch closely. Generally we start with a daily budget of $20 dollars and ramp up from there.

- Select your add style & content
  - This is what you will vary between each ad you run for this lander
- Rob will create the content you need
- Set the website URL to the lander URL
 - Add url parameters
    - `s1` will track the campaign, keep this unique for each add that directs to your lander
- Copy the pixel ID and go back to the lander manager
- Go to the Pixels tab
- Click add pixel funnel
- Paste in the value from facebook and click save



