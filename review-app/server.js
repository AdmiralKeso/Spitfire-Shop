const express = require('express');
const mongoose = require('mongoose');
const cors = require('cors');
const app = express();

// Middleware
app.use(cors());
app.use(express.json());

//Connect to mongooseDB
mongoose.connect('mongodb://127.0.0.1:27017/reviewsDB', {
    useNewUrlParser: true,
    useUnifiedTopology: true
}).then(() => console.log('Mongose is succesfully running.'))
.catch(err => console.log(err));

//Schema
const reviewSchema = new mongoose.Schema({
  productId: String,
  userName: String,
  rating: Number,
  comment: String,
  createdAt: { type: Date, default: Date.now }
});

const Review = mongoose.model('Review', reviewSchema);

// Routes
app.post('/reviews', async (req, res) => {
  try {
    const review = new Review(req.body);
    await review.save();
    res.status(201).json({ 
        success: true, 
        data: review });
  } catch (err) {
    return res.status(400).json({ 
        success: false, 
        message: "User name is required" });
  }
});

app.get('/reviews/:productId', async (req, res) => {
  const reviews = await Review.find({ productId: req.params.productId }); //Mongoose method to fetch documents from MongoDB.
  res.json(reviews);
});

app.listen(5000, () => {
  console.log("Review app is runnings on http://localhost:5000");
});

